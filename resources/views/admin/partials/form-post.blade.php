@php
    $methode = $post->title ? "PUT" : "POST";
@endphp

<form action="{{ route($post->title ? 'admin.post.update' : 'admin.post.store', [$post]) }}" method="post">
    @csrf
    @method( $methode )

    <div class="form-group mb-3">
        <label for="title">Titre de l'article</label><br>
        <input class="form-control @error('title') is-invalid @enderror" type="text" name="title"
               value="{{ old('title', $post->title) }}">
        @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <select class="form-select @error('category_id') is-invalid @enderror" name="category_id">
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
        <label for="content">Contenu de l'article</label><br>
        <textarea class="form-control @error('content') is-invalid @enderror"
                  name="content">{{ old('content', $post->content) }}</textarea>
        @error('content')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button class="btn btn-primary" type="submit">Envoyer</button>
</form>