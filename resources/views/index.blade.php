<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}"/>
    <title>Laravel Vue Link Shorter</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
</head>
<body class="bg-light">
    <main class="d-flex justify-content-center vh-100" style="margin-top: 8rem;">
        <div id="app"></div>
    </main>

    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>
</html>
