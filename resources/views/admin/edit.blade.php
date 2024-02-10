@extends('admin.base')

@section('title', 'Admin - Editer article')


@section('content')

    <div class="row mt-5 mb-4">
        <h1>Editer l'article</h1>
    </div>


    <div class="row">
        @include('admin.partials.form-post')
    </div>

@endsection