<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }} @if ($title) | {{ $title }} @endif</title>
    @vite("resources/css/app.scss")
</head>
<body class="antialiassed">

    {{ $slot }}

    @vite("resources/js/app.js")
</body>
</html>
