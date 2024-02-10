@php
    $methode = $category->name ? "PUT" : "POST";
@endphp

<form action="{{ route($category->name ? 'admin.category.update' : 'admin.category.store', [$category]) }}" method="post">
    @csrf
    @method( $methode )
    <div class="form-group mb-3">
        <label for="name">Titre de l'article</label><br>
        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
               value="{{ old('name', $category->name) }}">
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>



    <button class="btn btn-primary" type="submit">Envoyer</button>
</form>