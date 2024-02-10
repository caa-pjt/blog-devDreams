<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dev Dreams')</title>

    @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js'])

</head>

<body>
@php
    $className = request()->route()->getName();
@endphp

<div class="container">

    @if (session('success'))
        <div class="alert alert-success mt-5">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</html>
