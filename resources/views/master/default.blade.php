<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>HRis | {{ $pageTitle }}</title>

    @include('partials.copyleft')

    {!! Html::style('/css/bootstrap.min.css') !!}
    {!! Html::style('/font-awesome/css/font-awesome.css') !!}
    @yield('custom_css')
    {!! Html::style('/css/animate.css') !!}
    {!! Html::style('/min-css/style.min.css') !!}
</head>

<body class="pace-done fixed-sidebar">

    <div id="wrapper">

        @include('partials.navbar-static-side')

            <div class="row wrapper border-bottom greenpro-bg page-heading">
                <div class="col-sm-6">
                    <h2>{{ $pageTitle }}</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/">Home</a>
                        </li>
                        {!! HRis\Eloquent\Navlink::breadcrumb(Request::path()) !!}
                    </ol>
                </div>
                @yield('action_area')
            </div>
            <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content">
                    @yield('content')
                </div>
            </div>
        </div>

        @include('partials.footer')

        </div>
    </div>

    <!-- Mainly scripts -->
    {!! Html::script('/js/jquery-2.1.1.js') !!}
    {!! Html::script('/js/bootstrap.min.js') !!}
    {!! Html::script('/js/plugins/metisMenu/jquery.metisMenu.js') !!}
    {!! Html::script('/js/plugins/slimscroll/jquery.slimscroll.min.js') !!}

    <!-- Custom and plugin javascript -->
    {!! Html::script('/js/inspinia.js') !!}
    {!! Html::script('/js/plugins/pace/pace.min.js') !!}

    @yield('custom_js')


</body>

</html>
