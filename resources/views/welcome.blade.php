<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <title>Happy Kids</title>
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css?'.date('Ymdhis')) }}">
        <link rel="stylesheet" href="{{ asset('src/bootstrap/css/bootstrap.min.css?'.date('Ymdhis')) }}">
        <link rel="stylesheet" href="{{ asset('src/assets/css/light/main.css?'.date('Ymdhis')) }}">
        <link rel="stylesheet" href="{{ asset('src/assets/css/light/scrollspyNav.css?'.date('Ymdhis')) }}">
        <link rel="stylesheet" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css?'.date('Ymdhis')) }}">
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

        
        {{-- Front --}}
        <link rel="stylesheet" href="{{ asset('src/assets/css/light/authentication/auth-cover.css?'.date('Ymdhis')) }}">
        <link rel="stylesheet" href="{{ asset('src/template_layout/plugins.css?'.date('Ymdhis')) }}">

    </head>
    <body >
        <div id="app"></div>
        <script async defer src="{{ asset('js/app.js') }}"></script>
        <script async defer src="{{ asset('src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script async defer src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>
        {{-- <script async defer src="{{ asset('src/assets/css/light/scrollspyNav.js') }}"></script> --}}

    </body>
</html>
