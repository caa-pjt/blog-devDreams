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
        <label for="content">Contenu de l'article</label><br>
        <textarea class="form-control @error('content') is-invalid @enderror"
                  name="content">{{ old('content', $post->content) }}</textarea>
        @error('content')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button class="btn btn-primary" type="submit">Envoyer</button>
</form>