<?php

namespace App\Http\Controllers;

use App\Domain;
use App\Ticket;
use App\User;
use App\Plan;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Input;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $domain = Domain::where('user_id', Auth::user()->id)->first();
        if(strtolower(Auth::user()->type) == 'owner') {
            $hollers = Ticket::where(['user_id' => Auth::user()->id, 'complete' => 0])->orderBy('id', 'desc')->limit(3)->get();
            $members = [];
            $domains = [];
            $plan = Plan::find(Auth::user()->stripe_plan);
            if (in_array(Auth::user()->stripe_plan, [2, 3])) {
                $members = User::where('team_id', Auth::user()->id)->get();
                $domains = Domain::where('user_id', Auth::user()->id)->get();
            }

            return view('profile.index', compact('domain', 'hollers', 'members', 'plan', 'domains'));
        } else {
            $hollers = Ticket::where('user_id', Auth::user()->team_id)->orderBy('id', 'desc')->limit(3)->get();
            return view('profile.team-index', compact('hollers'));
        }
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
            'email' => 'required|unique:users,email,'.Auth::user()->id,
            'pasword' => 'confirmed'
        ]);

        if($validator->fails()) {
            return redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();
        $user->name = Input::get('name');
        $user->email = Input::get('email');
        if(Input::get('password') != "") {
            $user->password = Hash::make(Input::get('password'));
        }
        $user->save();

        // Messages
        flash()->success("Profile updated!", "Your changes have been saved");

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
    public function edit()
    {
        $domain = Domain::where('user_id', Auth::user()->id)->first();
        return view('profile.update', compact('domain'));
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

    public function plans(Request $request)
    {
        if($request->get('plan') != '') {
            $user = Auth::user();
            $user->subscription($request->get('plan'))->swap();
            return Redirect::to('/profile/plans');
        }
        return view('profile.plans');
    }

    public function cancel()
    {
        return view('profile.cancel');
    }

    public function shutdown()
    {
        $user = Auth::user();
        $user->subscription()->cancel();
        return Redirect::to('/profile');
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
