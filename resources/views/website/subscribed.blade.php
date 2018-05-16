@extends('layouts.website.register')
@section('content')
<section class="register">
            <h2 class="section-heading">Thank you!</h2>
            <br />
            <div class="col-lg-8 col-lg-offset-2">
                <div class="well">
                <p class="">You're all set. Just paste the following code into your website template and that's it - you have a helpdesk.</p>
                <br />
                <i>Please note, the DNS for your custom email address: <strong>support&#64;{{ $domain->stub }}.holr.help</strong> is currently being set up. It should only take 1 hour but please allow 24 hours before contacting us if there is an issue</i>
                </div>
                <textarea class="form-control" rows="20">
                {{ $snippet }}
                </textarea>
            </div>

</section>
@stop