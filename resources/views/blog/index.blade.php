@extends('base')

@section('title', "Mon super blog")

@section('content')

    @php
        echo "<pre>";
            print_r($posts);
        echo "</pre>";
    @endphp

@endsection