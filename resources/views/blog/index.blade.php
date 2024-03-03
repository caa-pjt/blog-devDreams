@extends('base')

@section('title', "Dev Dreams - MAS-RAD / DAR – Frameworks - Project")

@section('content')

    @include('partiales.blog-header')

    <section class="posts container">

        @include('partiales.notification')

        <h2 class="posts-title h1 pt-5 text-center">Nos derniers articles</h2>

        <livewire:blog-index/>

    </section>

@endsection
