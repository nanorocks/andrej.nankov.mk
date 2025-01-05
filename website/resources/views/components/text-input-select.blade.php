@props(['disabled' => false, 'options' => [], 'model' => null])

<select {{ $attributes->merge(['class' => 'select select-bordered w-full']) }}
    @if ($model) wire:model="{{ $model }}" @endif>
    @foreach ($options as $value => $label)
        <option value="{{ $value }}" @if ($model && $value == $this->getPropertyValue($model)) selected @endif>{{ $label }}
        </option>
    @endforeach
</select>
