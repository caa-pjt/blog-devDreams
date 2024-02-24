@extends('base')

@section('title', 'Se connecter')

@section('content')

    <div class="container-fluid">
        <div id="login" class="row d-flex justify-content-center align-content-center mh-76 m-0">
            <div class="card col-md-3 pt-4 px-4 pb-5">
                <div class="card-body">
                    <div class="mb-5">
                        <h2 class="text-uppercase text-center">Se connecter</h2>
                    </div>
                    <form action="{{ route("login") }}" method="post" class="d-flex justify-content-center flex-column">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="email">Email</label>
                            <input id="email" class="form-control @error('email') is-invalid @enderror" type="email"
                                   name="email"
                                   value="{{ old('email') }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="password">Mot de passe</label>
                            <input id="password" class="form-control @error('password') is-invalid @enderror"
                                   type="password"
                                   name="password">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg mt-2">Connection</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
