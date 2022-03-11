<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config( 'app.name' ) }}</title>

    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link href="{{ mix( 'css/app.css' ) }}" rel="stylesheet" type="text/css" media="all">

    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>
    <div id="app">
        <App/>
    </div>
</body>
</html>
