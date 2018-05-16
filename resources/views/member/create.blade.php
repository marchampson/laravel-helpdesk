@extends('layouts.website.register')
@section('content')
    <section class="register">
        <h2 class="section-heading"></h2>
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-default register-panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Add member</h3>
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
                            <input type="text" class="form-control" id="name" name="name" placeholder="Member full name" value="{!! old('name') !!}">
                        </div>
                        <br />
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Member email address" value="{!! old('email') !!}">
                        </div>
                        <br />
                        <a href="/profile" class="btn btn-default">Cancel</a>&nbsp;<input type="submit" name="submit" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop