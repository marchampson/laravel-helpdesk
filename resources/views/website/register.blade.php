@extends('layouts.website.register')
@section('content')
<section class="register">
            <h2 class="section-heading">Register</h2>
            <br />
            <div class="col-lg-6 col-lg-offset-3">
                <p class="white">After registering your details, you can select your plan. Don't forget, all plans come with 14 days free of charge and your card won't be charged until the end of that period. You can opt out at any time.</p>
                <br />
                <div class="panel panel-default register-panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Your details</h3>
                    </div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="" method="post" action="/create-account">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Your full name" value="{!! old('name') !!}">
                            </div>
                            <br />
                            <div class="form-group">
                                <label for="name">Domain</label>
                                <input type="text" class="form-control" id="domain" name="domain" placeholder="Full url, e.g. http://www.domain.com"  value="{!! old('domain') !!}">
                            </div>
                            <br />
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Your email address" value="{!! old('email') !!}">
                            </div>
                            <br />
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="{!! old('password') !!}">
                            </div>
                            <br />
                            <div class="form-group">
                                <label for="password_confirmation">Confirm password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Password confirmation">
                            </div>
                            <br />
                            <input type="submit" name="submit" class="btn btn-default">
                        </form>
                    </div>
                </div>
            </div>
</section>
@stop