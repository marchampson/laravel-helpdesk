@extends('layouts.website.register')
@section('content')
<section class="register">
            <h2 class="section-heading">Change Plan</h2>
            <br />
            <div class="col-lg-9 col-lg-offset-2">
                <section class="" id="pricing">
                    <div class="container">
                        <div class="row">
                            <div class="text-center">
                                <div class="row pricing">
                                    <div class="col-md-3">
                                        <div class="well pricing">
                                            <h3><b>Plan 1</b></h3>
                                            <hr>
                                            <p>1 domain</p>
                                            <hr>
                                            <p>1 agent</p>
                                            <hr>
                                            <p>1000 emails / pcm</p>
                                            <hr>
                                            <p>14 day free trial</p>
                                            <hr>
                                            <p><b>$5 / pcm</b></p>
                                            <hr>
                                            @if(Auth::user()->stripe_plan == '4')
                                                <button class="btn btn-primary" disabled>SUBSCRIBED</button>
                                            @else
                                            <form action="/profile/plans" method="POST">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <input type="hidden" name="plan" value="4">
                                                <input type="submit" class="btn btn-primary click_upgrade" value="UPGRADE">
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="well">
                                            <h3><b>Plan 2</b></h3>
                                            <hr>
                                            <p>5 domains</p>
                                            <hr>
                                            <p>2 agents</p>
                                            <hr>
                                            <p>5000 emails / pcm</p>
                                            <hr>
                                            <p>14 day free trial</p>
                                            <hr>
                                            <p><b>$20 / pcm</b></p>
                                            <hr>
                                            @if(Auth::user()->stripe_plan == '5')
                                                <button class="btn btn-primary" disabled>SUBSCRIBED</button>
                                            @else
                                                <form action="/profile/plans" method="POST">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    <input type="hidden" name="plan" value="5">
                                                    <input type="submit" class="btn btn-primary click_upgrade" value="UPGRADE">
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="well">
                                            <h3><b>Plan 3</b></h3>
                                            <hr>
                                            <p>10 domains</p>
                                            <hr>
                                            <p>3 agents</p>
                                            <hr>
                                            <p>10000 emails / pcm</p>
                                            <hr>
                                            <p>14 day free trial</p>
                                            <hr>
                                            <p><b>$35 / pcm</b></p>
                                            <hr>
                                            @if(Auth::user()->stripe_plan == '6')
                                                <button class="btn btn-primary" disabled>SUBSCRIBED</button>
                                            @else
                                                <form action="/profile/plans" method="POST">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    <input type="hidden" name="plan" value="6">
                                                    <input type="submit" class="btn btn-primary click_upgrade" value="UPGRADE">
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
</section>
@stop