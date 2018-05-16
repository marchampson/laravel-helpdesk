@extends('layouts.website.register')
@section('content')
<section class="register">
            <div class="col-lg-6 col-lg-offset-3">
                <br />
                <div class="panel panel-default register-panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Edit {{  apostropheS(Auth::user()->name) }} profile</h3>
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
                        <form class="" method="post" action="">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Your full name" value="{{ Auth::user()->name }}">
                            </div>
                            @if(Auth::user()->type == "owner")
                            <br />
                            <div class="form-group">
                                <label for="name">Domain</label>
                                <input type="text" class="form-control" id="domain" name="domain" placeholder="Full url, e.g. http://www.domain.com"  value="{{ $domain->domain }}" readonly>
                            </div>
                            @endif
                            <br />
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Your email address" value="{{ Auth::user()->email }}">
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
                            <a href="/profile" class="btn btn-default">Cancel</a>&nbsp;<input type="submit" name="submit" value="Update" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
</section>
@stop