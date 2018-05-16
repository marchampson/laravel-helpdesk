@extends('layouts.website.main')
@section('content')
    <header>
        <div class="header-content">
            <div class="header-content-inner">
                <img src="/img/logos/holr-logo-white.png" alt="holr logo" />
                <br />
                <br />
                <h1><strong>H</strong>elp <strong>O</strong>n-<strong>L</strong>ine... <strong>R</strong>einvented</h1>
                <hr>
                <p>Beautifully simple helpdesk software<br />Always available no matter where you are</p>
                <a href="#about" class="btn btn-primary btn-xl page-scroll">Find Out More</a>
            </div>
        </div>
    </header>

    <section class="bg-primary" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">Your own helpdesk in 3 easy steps</h2>
                    <hr class="light">
                    <p class="text-faded">holr [hol-ler] is an email based helpdesk that you and your visitors can use by simply pasting a snippet of code into your website. That's it, we'll take care of the rest!</p>
                    <br />
                    <p>Want to see it in action? Click on the 'Need help?' tab in the bottom right of the screen, send us a message and we'll get back to you.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="services">
        <!--  <div class="container">
             <div class="row">
                 <div class="col-lg-12 text-center">
                     <h2 class="section-heading">At Your Service</h2>
                     <hr class="primary">
                 </div>
             </div>
         </div> -->
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="service-box">
                        <!-- <i class="fa fa-4x fa-tasks wow bounceIn text-primary"></i> -->
                        <img src="/img/icons/Icon-01.png" alt="Register icon" />
                        <h3>Register</h3>
                        <p class="text-muted">Register your details and paste the generated code snippet into your website</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="service-box">
                        <!-- <i class="fa fa-4x fa-envelope wow bounceIn text-primary" data-wow-delay=".1s"></i> -->
                        <img src="/img/icons/Icon-02.png" alt="Inbox icon" />
                        <h3>Watch your inbox</h3>
                        <p class="text-muted">As soon as a vistor requests help, we'll ping an email direct to your inbox</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="service-box">
                        <!-- <i class="fa fa-4x fa-comments-o wow bounceIn text-primary" data-wow-delay=".2s"></i> -->
                        <img src="/img/icons/Icon-03.png" alt="Engage icon" />
                        <h3>Engage</h3>
                        <p class="text-muted">Respond to the email and keep you and your visitor happy.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-primary" id="pricing">
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <h2 class="section-heading">Pricing</h2>
                    <hr class="light">
                    <div class="row pricing">
                        <div class="col-md-4">
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
                                <a href="/register" class="btn btn-primary btn-block">Sign Up</a>
                            </div>
                        </div>
                        <div class="col-md-4">
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
                                <a href="/register" class="btn btn-primary btn-block">Sign Up</a>
                            </div>
                        </div>
                        <div class="col-md-4">
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
                                <a href="/register" class="btn btn-primary btn-block">Sign Up</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <br />
    <p class="copyright">holr by WK360 - copyright &copy; <?php echo date('Y'); ?>&nbsp;|&nbsp;<a href="/privacy">privacy</a>&nbsp;|&nbsp;<a href="/terms">terms</a></p>

@stop