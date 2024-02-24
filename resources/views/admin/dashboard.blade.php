@extends('admin-base')

@section('title', 'Administration du blog')


@section('content')
    <div class="row">
        <div class="col mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Panneau de l'admin</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-lg-6 col-sm-12">
            <div class="card mb-3">
                <div class="card-body">
                    <a href="{{ route('admin.post.index') }}">
                        <div class="stat-widget-one d-flex gap-3">
                            <div class="stat-icon dib">
                                <i class="bi bi-signpost-2 text-primary border-primary"></i>
                            </div>
                            <div class="stat-content dib">
                                <div class="stat-text">
                                    <h3 class="fs-4">Infos. articles</h3>
                                </div>
                                <div class="stat-digit d-flex gap-5 mt-2">
                                    <p>
                                        <span>En ligne</span>
                                        <strong>{{ $publishedPostCount }}</strong>
                                    </p>
                                    <p><span>Hors ligne</span> <strong>{{ $unpublishedPostCount }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-sm-12">
            <div class="card mb-3">
                <div class="card-body">
                    <a href="{{ route('admin.category.index') }}">
                        <div class="stat-widget-one d-flex gap-3">
                            <div class="stat-icon dib">
                                <i class="bi bi-bookmarks text-primary border-primary"></i>
                            </div>
                            <div class="stat-content dib">
                                <div class="stat-text">
                                    <h3 class="fs-4">Infos. Catégories</h3>
                                </div>
                                <div class="stat-digit d-flex gap-5 mt-2">
                                    <p>
                                        <span>Nbr. catégories</span>
                                        <strong>{{ $category }}</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- End row -->

    <div class="row">
        <div class="col-xl-4 col-lg-6 col-sm-12">
            <div class="card mb-3">
                <div class="card-header user-header alt bg-dark card text-white bg-flat-color-2">
                    <div class="media d-flex gap-3 media">
                        <div class="stat-icon dib pt-1">
                            <i class="bi bi-person text-white border-white"></i>
                        </div>

                        <div class="media-body">
                            <h2 class="text-light display-6">Profile</h2>
                            <p>De l'utilisateur</p>
                        </div>
                    </div>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex gap-4">
                        <p class="d-flex gap-2 m-0"><i class="bi bi-person-lock"></i>Nom</p>
                        <p class="m-0">-</p>
                        <p class="m-0"><strong>{{ $user['name'] }}</strong></p>
                    </li>
                    <li class="list-group-item d-flex gap-4">
                        <p class="d-flex gap-2 m-0">
                            <i class="bi bi-envelope-at"></i>Email
                        </p>
                        <p class="m-0">-</p>
                        <p class="m-0"><strong>{{ $user['email'] }}</strong></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End row user profile -->

@endsection
