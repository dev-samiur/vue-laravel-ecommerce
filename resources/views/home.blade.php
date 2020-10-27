<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Intérieur</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">

        <script src="{{ asset('js/app.js') }}" defer></script>

        <style>

            *{
                margin: 0px;
                padding: 0px;
                box-sizing: border-box;
                font-family: 'IBM Plex Mono', monospace;
                font-weight: 400;
            }

        </style>

    </head>
    <body>

        <div id="app">
            
        </div>
    </body>
</html>
