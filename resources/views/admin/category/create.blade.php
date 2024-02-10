@extends('admin.base')

@section('title', 'Admin - Nouvelle Catégorie')


@section('content')

    <div class="row mt-5 mb-4">
        <h1>Créer une nouvelle catégorie</h1>
    </div>

    <div class="row">
        @include('admin.partials.form-category')
    </div>

@endsection