@extends('admin-base')

@section('title', 'Admin - Nouvel Article')


@section('content')

    <div class="content mt-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <h1 class="fs-2">Gestion des articles</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('admin.partials.form-post')
            </div>
        </div>
    </div>

@endsection