<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dev Dreams')</title>

    @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js'])
<!-- asset('storage/logo_white.png') -->
</head>
<body>
@php
    $className = request()->route()->getName();
@endphp
<nav class="navbar navbar-expand-lg navbar bg-dark mb-3" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('logo_white.png') }}" class="img-fluid" alt="Dev Dream Logo" style="max-width: 50px"/>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a @class(['nav-link', 'active'=> $className === 'admin.post.index']) aria-current="page" href="{{
                            route('admin.post.index')}}">Les articles</a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link', 'active'=> $className === 'admin.category.index']) aria-current="page" href="{{
                            route('admin.category.index')}}">Les catégories</a>
                </li>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Me connecter</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

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
