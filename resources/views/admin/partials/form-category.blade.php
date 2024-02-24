@php
    $methode = $category->name ? "PUT" : "POST";
@endphp

<div class="card">
    <div class="card-body">
        <form action="{{ route($category->name ? 'admin.category.update' : 'admin.category.store', [$category]) }}"
              method="post">
            @csrf
            @method( $methode )
            <div class="row g-3 mb-3">
                <label for="name">Titre de la catégorie</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name"
                       value="{{ old('name', $category->name) }}">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button class="btn btn-primary" type="submit">Enregistrer</button>
        </form>
    </div>
</div>