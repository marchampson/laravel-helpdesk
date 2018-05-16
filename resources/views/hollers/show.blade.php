@extends('layouts.website.register')
@section('content')
<section class="register">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="/hollers">Back to hollers</a>
                {{--<h3 class="panel-title">{{ $holler->title }}</h3>--}}
            </div>
            <div class="panel-body">
                <h3><strong>Holler: </strong>{{ $holler->title }}</h3>
                <div class="col-lg-12 well">
                    <div class="col-lg-5 no-left-pad">
                        <strong>Name: </strong>{{ $holler->external_name }}<br />
                        <strong>Email: </strong>{{ $holler->external_email }}
                    </div>
                    <div class="col-lg-5">
                        <strong>Created: </strong>{{ $holler->created_at }}<br />
                    </div>
                    <div class="col-lg-12 no-left-pad top20">
                    <strong>Details:</strong><br />
                    {!! $holler->body !!}
                    <br />
                    <br />
                    <a class="btn btn-success" href="/hollers/{{$holler->id}}/complete">Close Holler</a>
                    </div>
                </div>
                <h3>Chatter</h3>
                <form method="post" action="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <textarea class="form-control" name="new_chatter" id="new_chatter" placeholder="Comment on this holler" rows="5"></textarea>
                    <br />
                    <button type="submit" class="btn btn-sm btn-primary">Add comment</button>
                </form>
                <hr />
                @foreach($chatters as $chatter)
                    <div class="col-lg-1 no-left-pad">
                            {!! gravatar($chatter->external_email,40) !!}
                    </div>
                    <div class="col-lg-11 chatter-text">
                        <strong>{{ $chatter->name }}</strong> wrote on <strong>{{ date('D dS F Y - H:i',strtotime($chatter->created_at)) }}</strong>
                        <br />
                        {!! $chatter->body !!}
                        <hr />
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@stop