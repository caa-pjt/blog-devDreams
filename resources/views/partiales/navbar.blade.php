<nav class="navbar navbar-expand-lg navbar bg-dark fixed-top" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home')  }}">
            <img src="{{ asset('images/logo_white.png') }}" class="img-fluid" alt="Dev Dream Logo"/>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a @class(['nav-link', 'active'=> $className === 'home']) href="{{
                            route('home')}}">Accueil</a>
                </li>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">


                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            {{ Auth::user()->username() }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.post.index') }}">Articles</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.category.index') }}">Catégories</a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                            <li>
                                <form method="post" action="{{ route('logout') }}">
                                    @csrf
                                    @method("delete")
                                    <button class="dropdown-item" type="submit">Se déconnecter</button>
                                </form>
                            </li>

                        </ul>
                    </li>
                @endauth


                <li class="nav-item">
                    @guest
                        <a @class(['nav-link', 'active'=> $className === 'login'])
                           href="{{ route("login") }}">Me connecter</a>
                    @endguest
                </li>
            </ul>
        </div>
    </div>
</nav>