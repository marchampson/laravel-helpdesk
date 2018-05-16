@extends('layouts.website.register')
@section('content')
<section class="register">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Your hollers</h3>
            </div>
            <div id="unseen" class="panel-body">
                <div class="form-group">
                <div class="checkbox">
                <label>
                @if($completed == 1)
                <input id="show_completed" data-href="/hollers" type="checkbox" name="remember" checked> Show completed
                @else
                <input id="show_completed" data-href="/hollers" type="checkbox" name="remember"> Show completed
                @endif
                </label>
                </div>
                </div>
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
                            @if($holler->complete == 0)
                            <td>{{ holler_status($holler->id, getUserEmail($holler->user_id)) }}</td>
                            @else
                            <td><label class="label label-success">Complete</label></td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@stop