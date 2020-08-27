<!DOCTYPE html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <base href="{{ asset('') }}">
    <script type="application/x-javascript">
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }

    </script>
    <!-- bootstrap-css -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- //bootstrap-css -->
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel='stylesheet' type='text/css' />
    <link href="{{ asset('css/style-responsive.css') }}" rel="stylesheet" />
    <!-- font CSS -->
    <link href="{{ asset('css/fonts.css') }}" rel='stylesheet' type='text/css'>
    <!-- font-awesome icons -->
    <link rel="stylesheet" href="{{ asset('css/font.css' ) }}" type="text/css" />
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/morris.css') }}" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/print.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatable.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/buttondatatable.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/selectdatable.css') }}">

    <script src="{{ asset('js/jquery2.0.3.min.js') }}"></script>
    <script src="{{ asset('js/print.js') }}"></script>
    <script src="{{ asset('js/raphael-min.js') }}"></script>
    <script src="{{ asset('js/morris.js') }}"></script>
    <script src="{{ asset('js/raphaelajax.js') }}"></script>
    <script src="{{ asset('js/ajax.js') }}"></script>
    <script src="{{ asset('js/order.js') }}"></script>
    <script src="{{ asset('js/report.js') }}"></script>
    <script src="{{ asset('js/validate.js') }}"></script>

    {{--  <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>  --}}
    <script src="{{ asset('js/bootstrapselect.min.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/datapicker.js') }}"></script>
    <script src="{{ asset('js/list.min.js') }}"></script>
    {{--  <script src="https://js.pusher.com/6.0/pusher.min.js"></script>  --}}
    <script src="{{ asset('js/pusher.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
</head>

