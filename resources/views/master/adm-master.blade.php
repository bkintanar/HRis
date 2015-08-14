<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>HRis | {{ $pageTitle }}</title>

    @include('partials.copyleft')

    {!! Html::style(elixir('css/all.css')) !!}
    @yield('custom_css')

    <link rel="icon" href="/favicon.png" type="image/png">

</head>

<body class="pace-done fixed-sidebar">

    <div id="wrapper">

        @include('partials.navbar-static-side')

            <div class="row wrapper border-bottom grad-red page-heading">
                <div class="col-sm-6">
                    <h2>{{ $pageTitle }}</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/">Home</a>
                        </li>
                        {!! Navlink::breadcrumb(Request::path()) !!}
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
    {!! Html::script(elixir('js/all.js')) !!}
    
    @yield('custom_js')

</body>

</html>
