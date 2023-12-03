<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <title>Happy Kids</title>
        
        <link rel="stylesheet" href="{{ asset('src/bootstrap/css/bootstrap.min.css?'.date('Ymdhis')) }}">
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

        @if ($display_type == 'portal') 
            <link rel="stylesheet" href="{{ asset('css/main.css') }}">
            <link rel="stylesheet" href="{{ asset('css/app.css?'.date('Ymdhis')) }}">
            <link rel="stylesheet" href="{{ asset('src/assets/css/light/main.css?'.date('Ymdhis')) }}">
            <link rel="stylesheet" href="{{ asset('src/assets/css/light/scrollspyNav.css?'.date('Ymdhis')) }}">
            <link rel="stylesheet" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css?'.date('Ymdhis')) }}">
            <link rel="stylesheet" href="{{ asset('src/plugins/src/table/datatable/datatables.css?'.date('Ymdhis')) }}">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
            <link rel="stylesheet" href="{{ asset('src/assets/css/light/authentication/auth-cover.css?'.date('Ymdhis')) }}">
            <link rel="stylesheet" href="{{ asset('src/template_layout/plugins.css?'.date('Ymdhis')) }}">
         @else 
            <link rel="stylesheet" href="{{ asset('front/css/animate.min.css') }}">
            <link rel="stylesheet" href="{{ asset('front/css/fontawesome-all.min.css') }}">
            <link rel="stylesheet" href="{{ asset('front/css/swiper.min.css') }}">
            <link rel="stylesheet" href="{{ asset('front/css/magnific-popup.css') }}">
            <link rel="stylesheet" href="{{ asset('front/css/odometer.min.css') }}">
            <link rel="stylesheet" href="{{ asset('front/css/azino-icons.css') }}">
            <link rel="stylesheet" href="{{ asset('front/css/bootstrap-select.min.css') }}">
            <link rel="stylesheet" href="{{ asset('front/css/main.css') }}">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.0/css/all.min.css" integrity="sha512-3PN6gfRNZEX4YFyz+sIyTF6pGlQiryJu9NlGhu9LrLMQ7eDjNgudQoFDK3WSNAayeIKc6B8WXXpo4a7HqxjKwg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        @endif
    </head>
    <body >
        <div id="app"></div>
        {{-- <script async defer src="{{ asset('src/assets/css/light/scrollspyNav.js') }}"></script> --}}
        <script async defer src="{{ asset('src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script async defer src="{{ asset('js/app.js') }}"></script>
        @if ($display_type == "portal") 
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
            <script async defer src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>

            {{-- datatable --}}
            <script async defer src="{{ asset('src/plugins/src/table/datatable/datatables.js') }}"></script>
            {{-- <script async defer src="{{ asset('src/plugins/src/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
            <script async defer src="{{ asset('src/plugins/src/table/datatable/button-ext/jszip.min.js') }}"></script>
            <script async defer src="{{ asset('src/plugins/src/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
            <script async defer src="{{ asset('src/plugins/src/table/datatable/button-ext/buttons.print.min.js') }}"></script>
            <script async defer src="{{ asset('src/plugins/src/table/datatable/custom_miscellaneous.js') }}"></script> --}}
        @else 
            {{-- front Landing--}}
            <script src="{{ asset('front/js/jquery-3.5.1.min.js') }}"></script>
            <script src="{{ asset('front/js/swiper.min.js') }}"></script>
            <script src="{{ asset('front/js/jquery.ajaxchimp.min.js') }}"></script>
            <script src="{{ asset('front/js/jquery.magnific-popup.min.js') }}"></script>
            <script src="{{ asset('front/js/jquery.validate.min.js') }}"></script>
            <script src="{{ asset('front/js/bootstrap-select.min.js') }}"></script>
            <script src="{{ asset('front/js/wow.js') }}"></script>
            <script src="{{ asset('front/js/odometer.min.js') }}"></script>
            <script src="{{ asset('front/js/jquery.appear.min.js') }}"></script>
            <!-- template js -->
            <script src="{{ asset('front/js/theme.js') }}"></script>
        
        @endif

    </body>
</html>
