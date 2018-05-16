<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Redirect;
use App\Plan;
use App\User;
use Auth;
use Input;
use Hash;
use Mail;

class MemberController extends Controller
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
        // Count number of members in team - if equal to max
        // redirect to profile with message
        $plan = Plan::find(Auth::user()->stripe_plan);
        $members = User::where(['type' => 'agent', 'team_id' => Auth::user()->id])->get();
        if($members && (count($members) == $plan->num_agents)) {
            flash()->error("Member Limit", "You have reached the maximum number of allowed members for your plan");
            return Redirect::to('/profile');
        }
        return view('member.create');
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
            'name' => 'required',
            'email' => 'required|unique:users',
        ]);

        if($validator->fails()) {
            return redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $password = str_random(10);

        $user = User::create([
           'name' => Input::get('name'),
            'email' => Input::get('email'),
            'password' => Hash::make($password),
            'team_id' => Auth::user()->id,
            'type' => 'agent'
        ]);

        $me = Auth::user();
        Mail::send('emails.new_user_notification', ['user' => $user, 'password' => $password, 'me' => $me], function($message) use($user, $me)
        {
            $message->to($user->email)
                ->from('noreply@holr.help')
                ->subject('Welcome to HOLR - You have been added to '.apostropheS($me->name).' team');
        });

        flash()->success("New user", $user->name . " has been added to your team");
        return Redirect::to('/profile');
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
        $member = User::find($id);
        return view('member.edit',compact('member'));
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
        User::find($id)->delete();
        return Redirect::to('/profile');
    }
}
