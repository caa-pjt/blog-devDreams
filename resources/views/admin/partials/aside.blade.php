@php
    $className = request()->route()->getName();
@endphp
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default" data-bs-theme="dark">
        <div class="navbar-header">
            <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#main-menu"
                    aria-controls="main-menu"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand d-flex gap-2"
               href="{{ route('home') }}">
                Dev Blog <strong>Admin</strong>
            </a>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav py-3">
                <li class="nav-item">
                    <a class="nav-link d-flex gap-5" href="{{ route ('home') }}">
                        <i class="bi bi-house-door"></i>Retour au blog
                    </a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link d-flex gap-5', 'active'=> $className === 'admin.dashboard'])
                       href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer"></i>Dashboard
                    </a>
                </li>
                <h3 class="menu-title">Eléments</h3>

                <li class="nav-item">
                    <a @class(['nav-link d-flex gap-5', 'active'=> $className === 'admin.post.index'])
                       href="{{ route('admin.post.index') }}">
                        <i class="bi bi-signpost-2"></i>Articles
                    </a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link d-flex gap-5', 'active'=> $className === 'admin.category.index'])
                       href="{{ route('admin.category.index') }}">
                        <i class="bi bi-bookmarks"></i>Catégories</a
                    >
                </li>

            </ul>
        </div>
        <!-- end navbar-collapse -->
    </nav>
</aside>