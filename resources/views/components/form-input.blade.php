<div class="{{ $class }}">


    @if($type != 'checkbox')
        <label for="{{ $name }}">{{ $label }}</label>

    @endif

    @if($type === 'textarea')
        <textarea name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder }}" rows="10"
                  class="form-control @error($name) is-invalid @enderror">{{ old($name, $value) }}</textarea>

    @elseif($type === 'file')

        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
               class="form-control @error($name) is-invalid @enderror">
        @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if(!empty($value['post-image']))
            <div class="mb-3 mt-3">
                <img src="{{ $value['image-url'] }}" alt="{{ $placeholder }}"
                     class="d-block img-fluid img-thumbnail mx-auto">
            </div>
        @endif

    @elseif($type === 'checkbox')
        <div class="form-check form-switch">
            <input class="form-check-input" id="{{ $name }}" name="{{ $name }}" type="checkbox"
                   value="1"{{ (old($name) == 1 || $value == 1) ? 'checked' : ''}}>

            <label class="form-check-label" for="{{ $name }}">{{ $label }}</label>
        </div>

    @elseif($type === 'select')

        <select class="form-select @error($name) is-invalid @enderror" id="{{ $name }}" name="{{ $name }}">

            <option disabled {{ (is_null(old($name)) && is_null($value)) ? 'selected' : ''}}>
                Choisir une option
            </option>

            @foreach ($options as $k => $v)
                <option value="{{ $k }}" {{ (old('category_id', $value) == $k) ? 'selected' : '' }}>
                    {{ $v }}
                </option>
            @endforeach

        </select>

    @else
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder }}"
               class="form-control @error($name) is-invalid @enderror" value="{{ old($name, $value) }}">
    @endif

    @if($type != 'file')
        @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    @endif

</div>