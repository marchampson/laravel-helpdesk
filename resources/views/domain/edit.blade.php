@extends('layouts.website.register')
@section('content')
    <section class="register">
        <h2 class="section-heading"></h2>
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-default register-panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit {{ $domain->domain }} <span class="pull-right"><button class="btn btn-danger btn-xs click_delete" href="/domain/{{$domain->id}}/delete">Delete</button></span></h3>
                </div>
                <div class="panel-body">
                <p>Domains cannot be amended once created. If you've made a mistake, please delete so that all DNS records are cleared and add a new domain</p>
                <br />
                <a href="/profile" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </section>
@stop