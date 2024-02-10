@extends('admin.base')

@section('title', 'Admin - Nouvel Article')


@section('content')

    <div class="row mt-5 mb-4">
        <h1>Administration des articles</h1>
    </div>


    <div class="row">
        @include('admin.partials.form-post')
    </div>

@endsection