<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' };</script>

        <title>Forecast</title>

        <link rel="stylesheet" href="{{ mix('css/icons.css') }}">
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script>
            var apiUrl = "{{ env('API_URL') }}";
        </script>
    </head>
    <body>

        <div id="app">
            <navbar></navbar>
            <div class="container">
                <router-view></router-view>
            </div>
        </div>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCeayhzKr0XHDaMZQMmfQWnSTrRVHCt384&libraries=places"></script>
        <script src="{{ asset('js/app.js') }}"></script>

    </body>
</html>
