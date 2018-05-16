<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">



    <!-- MetisMenu CSS -->
    <link href="/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="/css/plugins/dataTables.bootstrap.css" rel="stylesheet">


    @include('layouts.includes.core-header')

    <link href="/css/style.css" rel="stylesheet">

    <link href="/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">

</head>

<body>
@include('layouts.includes.navigation')
@include('flash')
<div class="container">
    <div id="wrapper" class="col-lg-12">
            @yield('content')
    </div>

    @include('layouts.includes.footer')

</div> <!-- /container -->
<!-- jQuery Version 1.11.0 -->
{{--<script src="/js/jquery-1.11.0.js"></script>--}}

<!-- Bootstrap Core JavaScript -->
{{--<script src="/js/bootstrap.min.js"></script>--}}

<!-- Metis Menu Plugin JavaScript -->
{{--<script src="/js/plugins/metisMenu/metisMenu.min.js"></script>--}}

<!-- DataTables JavaScript -->
<script src="/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="/js/plugins/dataTables/dataTables.bootstrap.js"></script>

<!-- jQuery UI 1.11.4 -->
<script src="/js/jquery-ui.min.js"></script>
<!-- Custom Theme JavaScript -->
{{--<script src="/js/sb-admin-2.js"></script>--}}

<script src="/js/plugins/sweetalert/sweetalert.min.js"></script>
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script> var _token = '<?php echo csrf_token(); ?>'; </script>
<script>
    $(document).ready(function() {

        $('.dropdown-toggle').dropdown();

        $(".clickable-row").click(function() {
            window.document.location = $(this).data("href");
        });

        $('#dataTables-example').dataTable({
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 10, "All"]],
            "columns": [null,null,{"orderable": false}],
            @if(isset($type) && strtolower($type) == "orders")
            "order": [[1, "desc"]],
            @else
            "order": []
            @endif
        });

        $('#dataTables-supplier').dataTable({
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 10, "All"]],
            "columns": [null,null,null,{"orderable": false}],
        });

        $('#dataTables-brief').dataTable({
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 10, "All"]],
        });

        $('#dataTables-users').dataTable({
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 10, "All"]],
        });

        $('#dataTables-brief-supplier').dataTable({
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 10, "All"]],
        });

    });

    $("#dataTables-supplier tbody").sortable({
        cursor: "move",
        update: function (event, ui) {
            var trArray = [];
            $('#dataTables-supplier tr').each(function () {
                var id = $(this).attr('id');
                if (id != undefined) {
                    trArray.push(id)
                }
            })
            console.log(trArray)
            $.ajax({
                type: "POST",
                url: '/datatables/updateroworder',
                data:{data: trArray, '_token': _token},

                success: function()
                {
                    console.log("OK");
                }
            });
        }

    });

//    $('.delete').click(function() {
//        if (confirm('Are you sure you wish to delete?')) {
//            var url = $(this).attr('href');
//            window.location.replace(url);
//        }
//    });
//
//    $('.archive').click(function() {
//        if (confirm('Are you sure you wish to archive this brief?')) {
//            var url = $(this).attr('href');
//            window.location.replace(url);
//        }
//    });

    $('#toggle-archived').click(function() {
        if($("#toggle-archived").prop('checked')) {
            $.ajax({
                type: "POST",
                url: "/set-archived-on",
                data: {
                  '_token': '{!! csrf_token() !!}'
                },
                success: function() {
                    window.location.reload();
                }
            });
            // Show archived
        } else {
            $.ajax({
                type: "POST",
                url: "/set-archived-off",
                data: {
                    '_token': '{!! csrf_token() !!}'
                },
                success: function() {
                    window.location.reload();
                }
            });
        }
    })

    $('div.alert').not('.alert-important').delay(5000).slideUp(300);

</script>
</body>
</html>
