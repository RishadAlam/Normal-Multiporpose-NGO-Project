<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <link href="{{ asset('storage/settings/' . $infos->logo) }}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Title -->
    <title>@stack('title'){{ __(' - ' . $infos->full_name) }}</title>
    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ asset('dist/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/css/print.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/css/style.css') }}" />
    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->

<body class="main" style="background: #fff">
    <!-- Report Header -->
    <section id="sheetHeader">
        <div class="conatiner-fluid">
            <div class="row">
                <div class="col-2 d-flex align-items-center">
                    <div class="logo">
                        <div class="img">
                            <img src="{{ asset('storage/settings/' . $infos->logo) }}" alt="logo">
                        </div>
                    </div>
                </div>
                <div class="col-8 text-center">
                    {{-- <h5>বিসমিল্লাহির রাহমানির রাহীম</h5> --}}
                    <h2><b>{{ $infos->full_name }}</b></h2>
                    <h3>{{ $infos->tagline }}</h3>
                    <h4>{{ $infos->address }}</h4>
                </div>
                <div class="col-2">
                </div>
            </div>
        </div>
    </section>
    <hr>

    <!-- Report Content -->
    <section id="reportContent">
        <div class="container-fluid">
            @yield('mainContent')
        </div>
    </section>

    <script src="{{ asset('dist/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('dist/js/app.js') }}"></script>
    <script src="{{ asset('dist/js/script.js') }}"></script>
    <!-- END: JS Assets-->
    <!-- START: Custom JS-->
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
    <!-- END: Custom JS-->
</body>

</html>
