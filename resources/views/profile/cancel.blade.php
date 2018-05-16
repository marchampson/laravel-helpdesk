@extends('layouts.website.register')
@section('content')
<section class="register">
    <div class="col-lg-10 col-lg-offset-1">
        <div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Cancel Subscription</h2>
                    <br />
                    <p>Don't do this to us! But if you really must go, thanks for trying the service. Please feel free to hit the holler tab at the bottom and let us know what we could have done to make you stay.</p>
                    <br />
                    <p>Hit the button below and your subscription will end at the current period and your card won't be charged again.</p>
                    <br />
                    <br />
                    <a href="/profile/initiate-shutdown" class="btn btn-danger">Cancel my subscription</a>
                </div>
            </div>

        </div>
    </div>
</section>
@stop