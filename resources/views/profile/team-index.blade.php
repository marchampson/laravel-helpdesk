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
        </div>
    </div>
</section>
@stop