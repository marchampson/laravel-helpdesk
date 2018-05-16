@extends('layouts.website.register')
@section('content')
    <section class="register">
        <h2 class="section-heading"></h2>
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-default register-panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Add domain</h3>
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
                            <label for="name">Domain</label>
                            <input type="text" class="form-control" id="domain" name="domain" placeholder="Full url, e.g. http://www.domain.com"  value="{!! old('domain') !!}">
                        </div>
                        <br />
                        <a href="/profile" class="btn btn-default">Cancel</a>&nbsp;<input type="submit" name="submit" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop