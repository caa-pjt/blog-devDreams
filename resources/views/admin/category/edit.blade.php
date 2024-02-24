@extends('admin-base')

@section('title', 'Admin - Editer article')


@section('content')

    <div class="row mt-5 mb-4">
        <h1>Editer la catégorie</h1>
    </div>


    <div class="row">
        @include('admin.partials.form-category')
    </div>

@endsection