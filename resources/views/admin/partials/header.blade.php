<header id="header" class="header">
    <div class="align-items-center d-flex header-menu justify-content-between my-2">
        <div class="">
            <h1 class="fs-5">Dashboard</h1>
        </div>
        <div class="">
            <div class="user-area dropdown text-end">
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    @method("delete")
                    <button class="dropdown-item" type="submit">Se déconnecter</button>
                </form>
            </div>
        </div>
    </div>
</header>