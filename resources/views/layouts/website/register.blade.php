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
    <link rel="stylesheet" href="/css/register.css" type="text/css">

    <!-- Favicon -->
    <link rel="icon" href="/img/favicons/favicon.ico" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- sweetalert -->
    <link rel="stylesheet" type="text/css" href="/css/sweetalert.css">

    <!-- holr css -->
    <link rel="stylesheet" href="/css/holr.css" type="text/css">



</head>

<body id="page-top">

<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand page-scroll" href="/">holr</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                @if(!Auth::check())
                    <li>
                        <a class="page-scroll" href="/#about">About</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="/#pricing">Pricing</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="/register">Register</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="/auth/login">Login</a>
                    </li>
                @else
                    <li>
                        <a class="page-scroll" href="/profile">Profile</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="/hollers">Your hollers</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="/auth/logout"><span title="{{ Auth::user()->name }}">{!! gravatar(Auth::user()->email,20) !!}</span> Log out</a>
                    </li>
                @endif
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
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
<script>
    $(document).ready(function() {
        $(".clickable-row").click(function() {
            window.document.location = $(this).data("href");
        });

        $("#show_completed").click(function() {
           if($('#show_completed').is(":checked")) {
               window.document.location = $(this).data("href") + '/completed';
           } else {
               window.document.location = $(this).data("href");
           }
        });

        $(".click_upgrade").click(function(e) {
            if(!confirm("Are you sure you want to change subscription?")) {
                return false;
            }
            $(this).submit();
        });

        $(".make_primary").click(function(e) {
            var id = $(this).attr('id');
            swal({
                        title: "Change primary domain",
                        text: "Are you sure you want to change?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtontext: "Yes, change it!",
                        cancelButtonText: "No, cancel",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            window.location.replace('/domain/'+id+'/primary');
                        } else {
                            swal("Cancelled", "Phew! That was close :)", "error");
                        }
                    });
        });

        $(".click_delete").click(function(e) {
            var url = $(this).attr('href');
            swal({
                        title: "Really?",
                        text: "Are you sure you want to delete?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtontext: "Yes, delete it!",
                        cancelButtonText: "No, cancel",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            window.location.replace(url);
                        } else {
                            swal("Cancelled", "Phew! That was close :)", "error");
                        }
                    });
        });


    });
</script>
<script src="/js/sweetalert.min.js"></script>
@include('flash')
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
