<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="google" content="notranslate" />
    <meta name="description" content="Benzinlik" />
    {{-- styles --}}
    <link rel="stylesheet" href="{{ asset('front/css/main.css') }}">
    <title>Benzinlik</title>
</head>

<body class="antialiased">
    {{-- header comes here --}}
    <div id="globalWrapper">

    </div>
    {{-- footer comes here --}}
</body>
<script src="{{ mix('js/website/app.js') }}"></script>

</html>
