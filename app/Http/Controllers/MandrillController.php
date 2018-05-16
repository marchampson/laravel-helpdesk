<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;
use PhpMimeMailParser\Parser;
use App\Message;
use App\Ticket;
use App\Log;
use Mandrill;
use Redirect;
use App\Domain;
use App\User;

class MandrillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $postvars = [];

        foreach($_POST as $key => $val) {
            $postvars[$key] = $val;
        }


        $data = ['data' => $postvars];
        Mail::send('emails.mandrill', $data, function($message)
        {
            $message->to('march@ed103.com', 'Hal 9000')->subject('Pod bay doors');
        });
    }

    public function inbound()
    {

        try {
            $mandrill = new Mandrill(env('MANDRILL_API'));
            $result = $mandrill->inbound->domains();
            echo '<pre>';
            print_r($result);
            echo '</pre>';

        } catch(Mandrill_Error $e) {
            // Mandrill errors are thrown as exceptions
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            // A mandrill error occurred: Mandrill_Invalid_Key - Invalid API key
            throw $e;
        }
    }

    public function addDomain($domain)
    {
        try {
            $mandrill = new Mandrill(env('MANDRILL_API'));
            $domain = strtolower($domain).'.holr.help';
            $result = $mandrill->inbound->addDomain($domain);
            echo '<pre>';
            print_r($result);
            echo '</pre>';

            return Redirect::to('/inbound');
        } catch(Mandrill_Error $e) {
            // Mandrill errors are thrown as exceptions
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            // A mandrill error occurred: Mandrill_Invalid_Key - Invalid API key
            throw $e;
        }
    }

    public function routes()
    {
        try {
            $mandrill = new Mandrill(env('MANDRILL_API'));
            $domain = 'ed103com.holr.help';
            $result = $mandrill->inbound->routes($domain);

            foreach($result as $route) {
                echo $route['id'];
            }

        } catch(Mandrill_Error $e) {
            // Mandrill errors are thrown as exceptions
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            // A mandrill error occurred: Mandrill_Unknown_InboundDomain - Unknown Inbound Domain: mandrill.com
            throw $e;
        }
    }

    public function addRoute($domain)
    {
        try {
            $mandrill = new Mandrill(env('MANDRILL_API'));
            $domain = strtolower($domain).'.holr.help';
            $pattern = 'support';
            $url = 'https://holr.help/mandrill';
            $result = $mandrill->inbound->addRoute($domain, $pattern, $url);
            echo '<pre>';
            print_r($result);
            echo '</pre>';
            /*
            Array
            (
                [id] => 7.23
                [pattern] => mailbox-*
                [url] => http://example.com/webhook-url
            )
            */
        } catch(Mandrill_Error $e) {
            // Mandrill errors are thrown as exceptions
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            // A mandrill error occurred: Mandrill_Unknown_InboundDomain - Unknown Inbound Domain: mandrill.com
            throw $e;
        }
    }


    /**
     * @param $stub
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @description Called when holr popup form is submitted
     */
    public function holr($stub, Request $request)
    {
        $domain = Domain::where('stub',$stub)->first();
        if($domain) {
            if ($request->input('email') != '') {

                $subject = 'Website form';
                $body = $request->input('message');
                $from_name = $request->input('name');
                $from = $request->input('email');

                $user = User::where('id',$domain->user_id)->first();
                $to = $user->email;

                $ticket = Ticket::create([
                    'domain_id' => $domain->id,
                    'user_id' => $domain->user_id,
                    'title' => $subject,
                    'body' => $body,
                    'external_name' => $from_name,
                    'external_email' => $from
                ]);

                Mail::send('emails.new_ticket_notification', ['body' => $body, 'ticket' => $ticket], function($message) use($ticket,$from,$to,$subject,$domain)
                {
                    $message->to($to)
                        ->from('support@'.$domain->stub.'.holr.help')
                        ->subject('HOLR Ticket #'.$ticket->id.' from '.$from. ' has been raised');
                });

                // Confirmation to originator
                Mail::send('emails.new_ticket_confirmation', ['body' => $body, 'ticket' => $ticket], function($message) use($ticket,$from,$to,$subject,$domain)
                {
                    $message->to($from)
                        ->from('support@'.$domain->stub.'.holr.help')
                        ->subject('HOLR Ticket #'.$ticket->id.' from '.$from. ' has been raised');
                });

                Message::create([
                    'email' => $request->input('email'),
                    'name' => $request->input('name'),
                    'message' => $request->input('message')
                ]);
                $response = ['status' => 'success', 'msg' => 'Added successfully'];
                return response()->json($response, 200, ['Content-Type' => 'application/javascript'])->setCallback($request->input('callback'));
            }
        } // Do we need a false return here?
    }


    public function newMessage(Request $request)
    {
        // Gather post from Mandrill or quit if emtpy
        $mandrillEvents = $request->input('mandrill_events', null);
        if(!$mandrillEvents) {
            return response()->json(['ok'], 200);
        }


        // Decode webhook and get text content of email
        $mail = json_decode($mandrillEvents);
        $to = $mail[0]->msg->email;
        $subject = $mail[0]->msg->subject;
        $from_name = $mail[0]->msg->from_name;
        $from = $mail[0]->msg->from_email;
        $body = $mail[0]->msg->html;

        // Extract sender's email and story from body of email
//        $senderEmail = $this->parseSenderEmail($body);
//        $senderName = $this->parseSenderName($body);

        // domain_id will be $mail[0]->msg->to without support@ and checked against domains table
        // HOLR Ticket #2
        if(substr($subject,0,17) == "Re: HOLR Ticket #") {
            $subjectBits = explode('#',$subject);
            $numberBits = explode(' ',$subjectBits[1]);
            $ticket = Ticket::find($numberBits[0]);
            $domain = Domain::find($ticket->domain_id);
            $agent = User::find($domain->user_id);
            if($ticket) {
                // Add log
                $log = Log::create([
                   'ticket_id' => $numberBits[0],
                   'agent_id' => $domain->user_id,
                   'body' => strip_tags(trim_gumpf($body)),
                   'name' => $from_name,
                   'external_email' => $from
                ]);

                // Get all logs in reverse order
                $logs = Log::where('ticket_id',$ticket->id)->orderBy('id','desc')->get();

                Mail::send('emails.log', ['body' => $body, 'ticket' => $ticket, 'logs' => $logs], function($message) use($ticket,$from,$to, $agent, $domain)
                {
                    $to_email = ($from == $ticket->external_email) ? $agent->email : $ticket->external_email;
                    $message->to($to_email)
                        ->from('support@'.$domain->stub.'.holr.help')
                        ->subject('HOLR Ticket #'.$ticket->id.' has been updated');
                });
            }
        } else {
            $toBits = explode('@',$to);
            $domainBits = explode('.',$toBits[1]);
            $domain = Domain::where('stub',$domainBits[0])->first();
            $agent = User::find($domain->user_id);
            $ticket = Ticket::create([
                'domain_id' => $domain->id,
                'user_id' => $domain->user_id,
                'title' => $subject,
                'body' => strip_tags($body, '<p><br><br />'),
                'external_name' => $from_name,
                'external_email' => $from
            ]);

            Mail::send('emails.new_ticket_notification', ['body' => $body, 'ticket' => $ticket], function($message) use($ticket,$from,$to,$subject,$domain,$agent)
            {
                $message->to($agent->email)
                    ->from('support@'.$domain->stub.'.holr.help')
                    ->subject('HOLR Ticket #'.$ticket->id.' from '.$from. ' has been raised');
            });

            // Confirmation to originator
            Mail::send('emails.new_ticket_confirmation', ['body' => $body, 'ticket' => $ticket], function($message) use($ticket,$from,$to,$subject, $domain)
            {
                $message->to($from)
                    ->from('support@'.$domain->stub.'.holr.help')
                    ->subject('HOLR Ticket #'.$ticket->id.' from '.$from. ' has been raised');
            });
        }

        // Write to db
        $message = Message::create([
            'email' => $from,
            'name' => $from_name,
            'message' => $body
        ]);




    }

    public function emailResponse()
    {
        dd('foo');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
