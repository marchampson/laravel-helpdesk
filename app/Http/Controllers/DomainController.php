<?php

namespace App\Http\Controllers;

use App\Domain;
use App\Plan;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Auth;
use Redirect;
use GuzzleHttp;
use Input;
use App\Jobs\AddMandrillDomain;
use App\Jobs\AddMemsetRecords;
use App\Jobs\AddMandrillRoute;
use Mandrill;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Count number of domain in team - if equal to max
        // redirect to profile with message
        $plan = Plan::find(Auth::user()->stripe_plan);
        $domains = Domain::where('user_id',Auth::user()->id)->get();
        if($domains && (count($domains) == $plan->num_domains)) {
            flash()->error("Domain Limit", "You have reached the maximum number of allowed domains for your plan");
            return Redirect::to('/profile');
        }
        return view('domain.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'domain' => 'required|unique:domains|url',
        ]);

        if($validator->fails()) {
            return redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create domain record
        $urlData = parse_url(Input::get('domain'));
        $stub = strtolower(str_replace('.','',str_replace('www.','',$urlData['host'])));
        $domain = Domain::create([
           'user_id' => Auth::user()->id,
            'domain' => Input::get('domain'),
            'stub' => $stub
        ]);

        // DNS
        // Memset
        $job = (new AddMemsetRecords($domain));
        $this->dispatch($job);
        // Mandrill
        // Add domain then route
        $job = (new AddMandrillDomain($domain))->delay(1800);
        $this->dispatch($job);
        // Add route

        $job = (new AddMandrillRoute($domain))->delay(1860);
        $this->dispatch($job);

        return Redirect::to('/domain/'.$domain->id.'/show');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $snippet = <<<EOT
<!-- holr scripts -->
<!-- Requirements: You will need Twitter Bootstrap and jQuery if you don't already have then -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="https://holr.help/scripts/css/holr.css" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://holr.help/scripts/js/jquery.validate.js"></script>
<!-- End of requirements -->
<div class="feedback"> <a class="feedback_button">Need help&#63;&nbsp;<img src="http://holr.help/img/logos/logo_whiteBG_100px.png" width="20px"/></a> <div class="form"> <h3><img src="http://holr.help/img/logos/logo_whiteBG_100px.png" class="form-logo"/>&nbsp;Need help&#63; Just holler!</h3> <strong>Simply fill out the form below and then track progress via email. It's that easy.</strong> <br/> <br/> <p class='modal-response-text' id="tag2">Got it... we heard you :) Check your inbox shortly for a reply<br/><br/><a class="feedback_button btn btn-default">Close</a></p><form id="holr-form" action="@@stub@@" method="post"> <div class="form-group" id="nameField"> <input type="text" class="form-control" id="holr_name" placeholder="Your name" required> </div><div class="form-group" id="emailField"> <input type="email" class="form-control" id="holr_email" placeholder="Your email" required> </div><div class="form-group" id="detailsField"> <textarea class="form-control" rows="3" id="holr_details" placeholder="How can we help?" required></textarea> </div><input type="submit" class="btn holr-button-text" id="holr_button" value="HOLR"> </form> </div></div>
<script src="https://holr.help/scripts/js/holr.js"></script>
<!-- end holr scripts -->
EOT;
        // how to get the current stub here?
        $domain = Domain::find($id);
        $snippet = str_replace('@@stub@@',$domain->stub,$snippet);

        // str_replace(@@stub@@ in $snippet
        return view('domain.show', compact('snippet','domain'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $domain = Domain::find($id);
        return view('domain.edit', compact('domain'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function primary($id)
    {
        // Set all domains to primary = 0 for this user
        $domains = Domain::where('user_id',Auth::user()->id)->get();
        foreach($domains as $domain) {
           if($domain->id == $id) {
               $domain->primary = 1;
           } else {
               $domain->primary = 0;
           }
           $domain->save();
        }
        flash()->success('Primary Domain Changed!', "");

        return Redirect::to('/profile');
        // Set primary = 1 for this id
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $domain = Domain::find($id);

        $client = new GuzzleHttp\Client();
        $res = $client->get('https://api.memset.com/v1/json/dns.zone_list', ['auth' => ['6a417319411545ebb322a716db820307', 'x']]);
        echo $res->getStatusCode(); // 200
        $decoded = json_decode($res->getBody());

        $zone_ids = [];
        foreach($decoded as $dm) {
            if(array_key_exists('0',$dm->domains)) {
                if($dm->domains[0]->domain == 'holr.help') {
                    foreach($dm->records as $record) {
                        if($record->record == "$domain->stub" && ($record->address == '30248469.in1.mandrillapp.com' || $record->address = '30248469.in2.mandrillapp.com')) {
                            $zone_ids[] = $record->id;
                        }
                    }
                }
            }
        }

        foreach($zone_ids as $zid) {
            $res = $client->get('https://api.memset.com/v1/json/dns.zone_record_delete', ['auth' =>  ['6a417319411545ebb322a716db820307', 'x'],
                'query' => [
                    'id' => $zid
                ]]);
            $res->getStatusCode();
        }

        // Mandrill
        $mandrill = new Mandrill(env('MANDRILL_API'));
        $mandrill_domain = $domain->stub.'.holr.help';
        // Find and delete routes
        try {
            $routes = $mandrill->inbound->routes($mandrill_domain);
            foreach($routes as $route) {
                $mandrill->inbound->deleteRoute($route['id']);
            }

        } catch(Mandrill_Error $e) {
            // Mandrill errors are thrown as exceptions
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            // A mandrill error occurred: Mandrill_Unknown_InboundDomain - Unknown Inbound Domain: mandrill.com
            throw $e;
        }

        // Remove domain
        try {

            $result = $mandrill->inbound->deleteDomain($mandrill_domain);
        } catch(Mandrill_Error $e) {
            // Mandrill errors are thrown as exceptions
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            // A mandrill error occurred: Mandrill_Invalid_Key - Invalid API key
            throw $e;
        }

        $domain->delete();

        flash()->success($domain->stub . ' deleted', '');
        return Redirect::to('/profile');
    }
}
