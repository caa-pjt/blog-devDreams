@php
    $methode = $category->name ? "PUT" : "POST";
@endphp

<div class="card">
    <div class="card-body">
        <form action="{{ route($category->name ? 'admin.category.update' : 'admin.category.store', [$category]) }}"
              method="post">
            @csrf
            @method( $methode )

            <x-form-input label="Titre de la catégorie" class="row g-3 mb-3"
                          name="name" placeholder="Nom de la catégorie" :value="$category->name"/>
            
            <button class="btn btn-primary" type="submit">Enregistrer</button>
        </form>
    </div>
</div>