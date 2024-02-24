<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dev Dreams')</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    @livewireStyles
</head>
<body class="pt-5">
@php
    $className = request()->route()->getName();
@endphp

@include("partiales.navbar")

<div @class(['container-height', 'container' => strpos($className, 'admin') !== false])>

    @include("partiales.notification")

    @yield('content')
</div>

@include("partiales.footer")
</body>

@livewireScripts

</html>
