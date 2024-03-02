@extends('admin-base')

@section('title', 'Administration de Articles')


@section('content')

    <!-- Posts content -->
    <div class="mt-4">
        <div class="row">
            <div class="col mb-4">
                <h1 class="fs-2">Gestion des articles</h1>
            </div>

            <!--Articles -->
            <div class="col-md-12">

                <livewire:posts-table :field="$field"
                                      :orderDirection="$orderDirection"
                                      :page="$page"
                                      :method="$method"/>

            </div>
            <!-- END Articles -->
        </div>
        <!-- End row -->
    </div>
    <!-- end Posts content -->

@endsection
