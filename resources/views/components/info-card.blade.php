@props(['label', 'value' => null, 'icon' => 'user'])
<article {{ $attributes->class(['info-card']) }}>
    <span class="icon-tile"><x-icon :name="$icon" /></span>
    <div><p class="label">{{ $label }}</p>@if($value)<h3>{{ $value }}</h3>@endif<div class="card-slot">{{ $slot }}</div></div>
</article>
