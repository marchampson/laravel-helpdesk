<?php

namespace App\Http\Controllers;

use App\Jobs\AddMandrillDomain;
use App\Jobs\AddMemsetRecords;
use App\Jobs\AddMandrillRoute;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Input;
use App\User;
use App\Domain;
use App\Team;
use Stripe;
use Hash;
use Auth;
use Mandrill;
use GuzzleHttp;
use Mail;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('website.home');
    }

    public function register(Request $request)
    {
        if($request->input('name')) {
            dd('foo');
        }
        return view('website.register');
    }

    public function createAccount(Request $request)
    {
        // Validate and store the blog post

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'domain' => 'required|unique:domains|url',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed'

        ]);

        if($validator->fails()) {
            return redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create user
        $user = User::create([
            'name' => Input::get('name'),
            'email' => Input::get('email'),
            'password' => Hash::make(Input::get('password')),
            'type' => 'owner'
        ]);

        // Create domain record
        $urlData = parse_url(Input::get('domain'));
        $stub = strtolower(str_replace('.','',str_replace('www.','',$urlData['host'])));
        $domain = Domain::create([
            'user_id' => $user->id,
            'primary' => 1,
            'domain' => Input::get('domain'),
            'stub' => $stub
        ]);

        // Login and go to plan selection
        Auth::loginUsingId($user->id);

        $email = Input::get('email');

        // Email user
        Mail::send('emails.new_account_notification', ['user' => $user, 'password' => Input::get('password')], function($message) use($email)
        {
            $message->to($email)
                ->from('noreply@holr.help')
                ->subject('Your new HOLR account has been created');
        });

        return Redirect::to('/plans');
    }

    public function plans(Request $request)
    {
        if($request->input('stripeToken')) {
            $token = Input::get('stripeToken');

            Auth::user()->subscription(Input::get('plan'))->create($token);

            return Redirect('/subscribed');
        }
        return view('website.plans');
    }

    public function subscribed()
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
        $domain = Domain::where('user_id',Auth::user()->id)->orderBy('id','desc')->first();
        $snippet = str_replace('@@stub@@',$domain->stub,$snippet);

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

        // str_replace(@@stub@@ in $snippet
        return view('website.subscribed', compact('snippet','domain'));
    }

    public function privacy()
    {
        return view('website.privacy');
    }

    public function terms()
    {
        return view('website.terms');
    }

}
