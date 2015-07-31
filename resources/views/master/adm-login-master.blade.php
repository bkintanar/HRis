<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <title>HRis | {{ $page_title }}</title>

    @include('partials.copyleft')

    {!! Html::style(elixir('css/all.css')) !!}

    <link rel="icon" href="/favicon.png" type="image/png">

</head>

<body class="gray-bg">

    @yield('content')

    <!-- Mainly scripts -->
    {!! Html::script(elixir('js/all.js')) !!}
</body>

</html>
