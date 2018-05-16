@extends('layouts.website.register')
@section('content')
<section class="register">
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{  apostropheS(Auth::user()->name) }} profile</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="" align="center"> {!! gravatar(Auth::user()->email, 100) !!} </div>
                    <br />
                    <div class="">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>Email:</td>
                                <td>{{ Auth::user()->email }}</td>
                            </tr>
                            <tr>
                                <td>Primary Domain:</td>
                                <td>{{ $domain->domain }}</td>
                            </tr>
                            <tr>
                                <td>Plan:</td>
                                <td>{{ $plan->name }}&nbsp;&nbsp;&nbsp;[<a href="/profile/plans">change</a>&nbsp;|&nbsp;<a href="/profile/cancel-subscription">cancel</a>]</td>
                            </tr>
                            <tr>
                            @if(strtotime(Auth::user()->trial_ends_at) > time())
                            <tr>
                                <td>Trial ends</td>
                                <td>{{ Auth::user()->trial_ends_at }}</td>
                            </tr>
                            @endif
                            @if(strtotime(Auth::user()->subscription_ends_at) > time())
                                <tr>
                                    <td>Subscription ends</td>
                                    <td>{{ Auth::user()->subscription_ends_at }}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row profile-button">
                <a href="/profile/edit" class="btn btn-primary btn-sm">Edit profile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Latest hollers</h3>
                </div>
                <div id="unseen" class="panel-body">
                    @if(count($hollers) > 0)
                    <table class="table table-hover">
                        <thead>
                        <th>Title</th>
                        <th>Body</th>
                        <th>Domain</th>
                        <th>Raised by</th>
                        <th>Created</th>
                        <th>Waiting for</th>
                        </thead>
                        <tbody>
                        @foreach($hollers as $holler)
                            <tr class="clickable-row" role="row" data-href="/hollers/{{ $holler->id }}/show">
                                <td>{{ $holler->title }}</td>
                                <td>{{ substr(strip_tags($holler->body),0,50) }}</td>
                                <td>{{ getDomainName($holler->domain_id) }}</td>
                                <td>{{ $holler->external_name }}</td>
                                <td>{{ date('d-m-Y',strtotime($holler->created_at)) }}</td>
                                <td>{{ holler_status($holler->id, getUserEmail($holler->user_id)) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                        <p>All quiet...</p>
                    @endif
                </div>
            </div>
            @if(in_array(Auth::user()->stripe_plan,['2','3']))
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Team members {{ team_member_count() }}</h3>
                </div>
                <div id="unseen" class="panel-body">
                    @if(count($members) > 0)
                    <table class="table table-hover">
                        <thead>
                        <th>Name</th>
                        <th>Email</th>
                        </thead>
                        <tbody>
                        @foreach($members as $member)
                            <tr class="clickable-row" role="row" data-href="/member/{{ $member->id }}/edit">
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->email }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @endif
                    <a href="/member/create" class="btn btn-primary btn-sm">Add a team member</a>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Domains {{ domain_count() }}</h3>
                </div>
                <div id="unseendomains" class="panel-body">
                    @if(count($domains) > 0)
                        <table class="table table-hover">
                            <thead>
                            <th>Domain</th>
                            <th>Support Email</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            </thead>
                            <tbody>
                            @foreach($domains as $dm)
                                <tr>
                                    <td>{{ $dm->domain }}</td>
                                    <td>support&#64;{{ $dm->stub }}.holr.help</td>
                                    <td>{!! optimus_primary($dm->primary, $dm->id) !!}</td>
                                    <td><a href="/domain/{{ $dm->id }}/show">Code snippet</a></td>
                                    @if($dm->primary != 1)
                                    <td><a href="/domain/{{$domain->id}}/edit">Edit</a></td>
                                    @else
                                    <td></td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                    <a href="/domain/create" class="btn btn-primary btn-sm">Add a new domain</a>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@stop