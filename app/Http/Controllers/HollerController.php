<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ticket;
use App\Log;
use App\Domain;
use Mail;
use App\User;
use Auth;
use Input;
use Redirect;

class HollerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status = null)
    {
        $hollers = [];
        $completed = 0;
        if($status == 'completed') {
            $hollers = Ticket::where(['user_id' => Auth::user()->id, 'complete' => 1])->orderBy('id', 'desc')->get();
            $completed = 1;
        } else {
            $hollers = Ticket::where(['user_id' => Auth::user()->id, 'complete' => 0])->orderBy('id', 'desc')->get();
        }
        return view('hollers.index',compact('hollers', 'completed'));
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
        $holler = Ticket::find($id);
        $chatters = Log::where('ticket_id',$id)->orderBy('id','desc')->get();
        return view('hollers.show', compact('holler','chatters'));
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
        if($request->get('new_chatter') == '') {
            return Redirect::to('/hollers/'.$id.'/show');
        }

        Log::create([
            'ticket_id' => $id,
            'agent_id' => Auth::user()->id,
            'body' => Input::get('new_chatter'),
            'name' => Auth::user()->name,
            'external_email' => Auth::user()->email
        ]);

        $ticket = Ticket::find($id);
        $domain = Domain::find($ticket->domain_id);
        $agent = User::find($domain->user_id);

        // Get all logs in reverse order
        $logs = Log::where('ticket_id',$ticket->id)->orderBy('id','desc')->get();

        Mail::send('emails.log', ['body' => Input::get('new_chatter'), 'ticket' => $ticket, 'logs' => $logs], function($message) use($ticket, $agent, $domain)
        {
            $message->to($ticket->external_email)
                ->from('support@'.$domain->stub.'.holr.help')
                ->subject('HOLR Ticket #'.$ticket->id.' has been updated');
        });

        // Messages
        flash()->success("Done!", "Your chatter update has been saved");

        return Redirect::to('/hollers/'.$id.'/show');
    }

    public function complete($id)
    {
        $holler = Ticket::find($id);
        $holler->complete = 1;
        $holler->save();
        flash()->success('Holler complete', 'Your holler has been marked as complete');
        return Redirect::to('/hollers');
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
