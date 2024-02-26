@props(['field', 'label', 'orderField', 'orderDirection'])
@php
    $currentQuery = request()->query(); // Récupère les paramètres de l'URL actuel
    $currentQuery['order'] = $field; // Remplace ou ajoute le paramètre 'order' avec la valeur de $field
    $currentQuery['direction'] = $orderDirection === 'asc' ? 'desc' : 'asc'; // Remplace ou ajoute le paramètre 'direction' avec la valeur opposée

@endphp
<th wire:click="setOrderField('{{ $field }}')">
    <a wire:click.prevent href="{{ route('admin.post.index', ['order' => $field, 'direction' => $orderDirection === 'asc' ? 'desc' :
    'asc']) }}" class="link-dark">
        {{ $label }}
        @if($orderField === $field)
            @if($orderDirection === 'asc')
                <i class="bi bi-arrow-up"></i>
            @else
                <i class="bi bi-arrow-down"></i>
            @endif
        @else
            <i class="bi bi-arrow-down-up"></i>
        @endif
    </a>
</th>