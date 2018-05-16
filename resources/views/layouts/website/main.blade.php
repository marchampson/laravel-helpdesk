<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>holr - helpdesk on-line reinvented > beautifully simple helpdesk software</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css" type="text/css">

    <!-- Custom Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css" type="text/css">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="/css/animate.min.css" type="text/css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/creative.css" type="text/css">

    <!-- Favicon -->
    <link rel="icon" href="/img/favicons/favicon.ico" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- holr css -->
    <link rel="stylesheet" href="/css/holr.css" type="text/css">

</head>

<body id="page-top">

<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
@include('layouts.website.includes.nav')
</nav>

@yield('content')

<!-- jQuery -->
<script src="/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="/js/bootstrap.min.js"></script>

<!-- Plugin JavaScript -->
<script src="/js/jquery.easing.min.js"></script>
<script src="/js/jquery.fittext.js"></script>
<script src="/js/wow.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="/js/creative.js"></script>

<!-- holr scripts -->
<script src="https://holr.help/scripts/js/jquery.validate.js"></script>
<div class="feedback">
    <a class="feedback_button">Need help? &nbsp;<img src="/img/logos/logo_whiteBG_100px.png" width="20px" /></a>
    <div class="form">
        <h3><img src="/img/logos/logo_whiteBG_100px.png" class="form-logo"/>&nbsp;Need help? Just holler!</h3>
        <strong>Simply fill out the form below and then track progress via email. It's that easy.</strong>
        <br />
        <br />
        <p class='modal-response-text' id="tag2">Got it... we heard you :) Check your inbox shortly for a reply<br /><br /><a class="feedback_button btn btn-default">Close</a></p>
        <form id="holr-form" action="ed103com" method="post">
            <div class="form-group" id="nameField">
                <input type="text" class="form-control" id="holr_name" placeholder="Your name" required>
            </div>
            <div class="form-group" id="emailField">
                <input type="email" class="form-control" id="holr_email" placeholder="Your email" required>
            </div>
            <div class="form-group" id="detailsField">
                <textarea class="form-control" rows="3" id="holr_details" placeholder="How can we help?" required></textarea>
            </div>
            <input type="submit" class="btn holr-button-text" id="holr_button" value="HOLR">
        </form>
    </div>
</div>
<script src="/js/holr.js"></script>
<!-- end holr scripts -->
</body>

</html>
