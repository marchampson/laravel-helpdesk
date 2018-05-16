@if (session()->has('flash_message'))
    {{--<div class="alert alert-{{ session('flash_message.level') }}" role="alert">{{ session('flash_message.title')}} {{ session('flash_message.message') }}</div>--}}
    <script>
    swal({
    title: "{{ session('flash_message.title') }}",
    text: "{{ session('flash_message.message') }}",
    type: "{{ session('flash_message.level') }}",
    timer: 1700,
    showConfirmButton: false
    });
    </script>
@endif

@if (session()->has('flash_message_overlay'))
    <script>
        swal({
            title: "{{ session('flash_message_overlay.title') }}",
            text: "{{ session('flash_message_overlay.message') }}",
            type: "{{ session('flash_message_overlay.level') }}",
            confirmButtontext: 'Ok'
        });
    </script>
@endif

