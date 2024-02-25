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
                        <x-form-input label="Titre de la catégorie"
                                      name="title" placeholder="Titre de l'article" :value="$post->title"/>

                        <x-form-input label="Slug de la catégorie"
                                      name="slug" placeholder="Slug de l'article" :value="$post->slug"/>


                        <x-form-input label="Catégorie de l'article" name="category_id" :value="$post->category_id"
                                      type="select" :options="$categories->pluck('name', 'id')->toArray()"/>


                        <x-form-input label="Contenu de l'article" name="content" :value="$post->content"
                                      placeholder="Contenu de l'article" type="textarea"/>


                        <x-form-input label="Article en ligne ?" name="published" :value="$post->published"
                                      type="checkbox"/>


                    </div>

                    <div class="col-md-4">

                        <x-form-input label="Image à la une" name="image"
                                      :value="['post-image' => $post->image, 'image-url' => $post->imageUrl()]"
                                      type="file"/>

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