<html>
<body>
<p>//================== Reply above this line ==================//</p>
@foreach($logs as $log)
    <strong>{{ $log->name }}</strong> wrote on <strong>{{ date('D dS F Y - H:i',strtotime($log->created_at)) }}</strong>
    <br />
    <br />
    {!! $log->body !!}
    <hr />
@endforeach
</body>
</html>
