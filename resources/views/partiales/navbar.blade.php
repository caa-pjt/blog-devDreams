<nav class="navbar navbar-expand-lg navbar bg-dark fixed-top" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('logo_white.png') }}" class="img-fluid" alt="Dev Dream Logo" style="max-width: 50px"/>
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
                @auth
                <li class="nav-item">
                    <a @class(['nav-link', 'active'=> $className === 'admin.post.index']) href="{{
                            route('admin.post.index')}}">Les articles</a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link', 'active'=> $className === 'admin.category.index']) href="{{
                            route('admin.category.index')}}">Les catégories</a>
                </li>
                @endauth
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <form method="post" action="{{ route('logout') }}">
                                    @csrf
                                    @method("delete")
                                    <button class="dropdown-item" type="submit">Se déconnecter</button>
                                </form>
                            </li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    @endauth
                    @guest
                        <a @class(['nav-link', 'active'=> $className === 'login']) href="{{ route("login") }}">Me connecter</a>
                    @endguest
                </li>
            </ul>
        </div>
    </div>
</nav>