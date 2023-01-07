<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}" />
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <title>Kanban Laravel|Vue</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <div id="app">
        <app-component></app-component>
    </div>
    @vite(['resources/js/app.js'])
</body>
</html>