<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>HRis | Login</title>

    @include('partials.copyleft')

    {!! Html::style('/css/bootstrap.min.css') !!}
    {!! Html::style('/font-awesome/css/font-awesome.css') !!}

    {!! Html::style('/css/animate.css') !!}
    {!! Html::style('/min-css/style.min.css') !!}

</head>

<body class="gray-bg">

    @yield('content')

    <!-- Mainly scripts -->
    {!! Html::script('/js/jquery-2.1.1.js') !!}
    {!! Html::script('/js/bootstrap.min.js') !!}

</body>

</html>
