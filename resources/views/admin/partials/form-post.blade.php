@php
    $methode = $post->title ? "PUT" : "POST";
@endphp

<form action="{{ route($post->title ? 'admin.post.update' : 'admin.post.store', [$post]) }}" method="post">
    @csrf
    @method( $methode )

    <div class="form-group mb-3">
        <label for="title">Titre de l'article</label>
        <input class="form-control @error('title') is-invalid @enderror" id="title" type="text" name="title"
               value="{{ old('title', $post->title) }}">
        @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="category">Catégorie de l'article</label>
        <select class="form-select @error('category_id') is-invalid @enderror" id="category" name="category_id">
            <option disabled {{ (is_null(old('category_id')) && is_null($post->category_id)) ? 'selected' : ''}}>
                Choisire une option
            </option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ (old('category_id', $post->category_id) == $category->id) ?
                'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="content">Contenu de l'article</label>
        <textarea class="form-control @error('content') is-invalid @enderror"
             id="content" name="content">{{ old('content', $post->content) }}</textarea>
        @error('content')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <div class="form-check form-switch">
            <input class="form-check-input" id="published" type="checkbox" role="switch" name="published" {{ old('content', $post->published) == 1 ? 'checked' : '' }}>
            <label class="form-check-label" for="published">Article en ligne ?</label>
        </div>
    </div>

    <button class="btn btn-primary" type="submit">Envoyer</button>
</form>