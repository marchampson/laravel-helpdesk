@extends('layouts.website.register')
@section('content')
    <section class="register">
        <h2 class="section-heading">{{ $domain->stub }}</h2>
        <br />
        <div class="col-lg-8 col-lg-offset-2">
            <div class="well">
            <p class="">You're all set. Just paste the following code into your website template to start receiving hollers from this domain</p>
            <br />
            <i>Please note, if you have just added this domain, the DNS for your custom email address: <strong>support&#64;{{ $domain->stub }}.holr.help</strong> will take about 1 hour to setup. Please allow 24 hours before contacting us if there is an issue</i>
            </div>
            <br />
            <br />
                <textarea class="form-control" rows="20">
                {{ $snippet }}
                </textarea>
        </div>

    </section>
@stop