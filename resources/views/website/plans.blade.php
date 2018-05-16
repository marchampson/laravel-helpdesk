@extends('layouts.website.register')
@section('content')
<section class="register">
            <h2 class="section-heading">Select Plan</h2>
            <br />
            <div class="col-lg-9 col-lg-offset-2">
                <p class="white">After selecting your plan you will need to enter your card details, but your card will <strong>not</strong> be charged until the 14 day trial has finished. You can opt out at any time. We use <a href="http://www.stripe.com" target="_blank">Stripe</a> to handle all of our payments. Your card details are securely handled and never even touch our servers.</p>
                <br />
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
                                            <form action="" method="POST">
                                                <input type="hidden" name="plan" value="4">
                                                <script
                                                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                        data-key="{{ env('STRIPE_KEY') }}"
                                                        data-amount="500"
                                                        data-currency="USD"
                                                        data-name="holr"
                                                        data-description="Plan 1 ($5)"
                                                        data-image="/img/logos/logo_whiteBG_100px.png"
                                                        data-locale="auto">
                                                </script>
                                            </form>
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
                                            <form action="" method="POST">
                                                <input type="hidden" name="plan" value="5">
                                                <script
                                                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                        data-key="{{ env('STRIPE_KEY') }}"
                                                        data-amount="2000"
                                                        data-currency="USD"
                                                        data-name="holr"
                                                        data-description="Plan 2 ($20)"
                                                        data-image="/img/logos/logo_whiteBG_100px.png"
                                                        data-locale="auto">
                                                </script>
                                            </form>
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
                                            <form action="" method="POST">
                                                <input type="hidden" name="plan" value="6">
                                                <script
                                                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                        data-key="{{ env('STRIPE_KEY') }}"
                                                        data-amount="3500"
                                                        data-currency="USD"
                                                        data-name="holr"
                                                        data-description="Plan 3 ($35)"
                                                        data-image="/img/logos/logo_whiteBG_100px.png"
                                                        data-locale="auto">
                                                </script>
                                            </form>
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