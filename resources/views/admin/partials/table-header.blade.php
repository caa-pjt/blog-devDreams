@props(['field', 'label', 'orderField', 'orderDirection', 'search'])
@php
    $currentQuery = request()->query(); // Récupère les paramètres de l'URL actuel
    $currentQuery['order'] = $field; // Remplace ou ajoute le paramètre 'order' avec la valeur de $field
    $currentQuery['direction'] = $orderDirection === 'asc' ? 'desc' : 'asc'; // Remplace ou ajoute le paramètre 'direction' avec la valeur opposée

    // Vérifie si la clé 'search' existe dans le tableau $currentQuery
    if (array_key_exists('search', $currentQuery)) {
        // Ajoute le paramètre 'search' avec la valeur de la recherche actuelle si elle n'est pas vide
        if (!empty($search)) {
            $currentQuery['search'] = $search;
        }else{
            // Supprime le paramètre 'search' si la recherche est vide
            unset($currentQuery['search']);
        }
    }

@endphp
<th wire:click="setOrderField('{{ $field }}')">
    <a wire:click.prevent href="{{ route('admin.post.index', $currentQuery) }}" class="link-dark">
        {{ $label }}
        @if($orderField === $field)
            @if($orderDirection === 'asc')
                <i class=" bi bi-arrow-up"></i>
            @else
                <i class="bi bi-arrow-down"></i>
            @endif
        @else
            <i class="bi bi-arrow-down-up"></i>
        @endif
    </a>
</th>