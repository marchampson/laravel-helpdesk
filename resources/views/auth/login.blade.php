@extends('layouts.website.register')
@section('content')
<section class="register">
    <h2 class="section-heading"><img src="/img/logos/logo_whiteBG_100px.png" alt="holr logo" /></h2>
    <br />
    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel panel-default register-panel">
            <div class="panel-heading">
                <h3 class="panel-title">HOLR Login</h3>
            </div>
            <div class="panel-body">
                <form method="POST" action="/auth/login">
                    {!! csrf_field() !!}

                    <div>
                        Email
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>
                    <br />
                    <div>
                        Password
                        <input type="password" name="password" class="form-control" id="password">
                    </div>
                    <br />

                    {{--<div class="form-group">--}}
                            {{--<div class="checkbox">--}}
                                {{--<label>--}}
                                    {{--<input type="checkbox" name="remember"> Remember Me--}}
                                {{--</label>--}}
                            {{--</div>--}}
                    {{--</div>--}}

                    <div class="form-group">
                        <div>
                            <button class="btn btn-default" type="submit">Login</button>
                            <br />
                            <br />
                            <a class="" href="{{ url('/password/email') }}">Forgot Your Password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@stop
