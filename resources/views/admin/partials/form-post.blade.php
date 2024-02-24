@php
    $methode = $post->title ? "PUT" : "POST";
@endphp

<form action="{{ route($post->title ? 'admin.post.update' : 'admin.post.store', [$post]) }}" method="post"
      enctype="multipart/form-data">
    @csrf
    @method( $methode )

    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label class="form-label" for="title">Titre de l'article</label>
                            <input class="form-control @error('title') is-invalid @enderror" id="title" type="text"
                                   placeholder="Titre de l'article" name="title"
                                   value="{{ old('title', $post->title) }}">
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" for="category">Catégorie de l'article</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category"
                                    name="category_id">
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
                            <label class="form-label" for="content">Contenu de l'article</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" rows="10"
                                      id="content" placeholder="Contenu de l'article"
                                      name="content">{{ old('content', $post->content) }}</textarea>
                            @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" id="published" type="checkbox" role="switch"
                                       name="published" {{ old('content', $post->published) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="published">Article en ligne ?</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="image" class="form-label">Choisir une image</label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
                                   name="image">
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($post->image)
                            <div class="mb-3">
                                {{-- asset('storage/'. $post->image) --}}
                                <img src="{{ $post->imageUrl() }}" alt="Image de l'article" class="img-thumbnail">
                            </div>
                        @endif
                    </div>
                    <div class="col">
                        <button class="btn btn-primary" type="submit">Enregistrer</button>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
        <!-- End Card -->
    </div>
</form>