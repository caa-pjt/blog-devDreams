<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dev Dreams')</title>

    @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js'])
<!--<img src="{{asset('storage/logo.png')}}" style="max-width: 100px"/>-->
</head>
<body class="pt-5">
@php
    $className = request()->route()->getName();
@endphp

    @include("partiales.navbar")

    <div class="container mt-5">

        @include("partiales.notification")

        @yield('content')
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</html>
