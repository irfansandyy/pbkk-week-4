@props(['type' => 'success', 'title' => null, 'dismissible' => true])
<div {{ $attributes->class(['status-banner', 'status-error' => $type === 'error']) }} role="{{ $type === 'error' ? 'alert' : 'status' }}" data-banner>
    <span class="status-icon"><x-icon :name="$type === 'error' ? 'spark' : 'check'" /></span>
    <div>@if($title)<strong>{{ $title }}</strong>@endif<div>{{ $slot }}</div></div>
    @if($dismissible)<button type="button" class="icon-button dismiss-banner" aria-label="Tutup notifikasi"><x-icon name="close" size="17" /></button>@endif
</div>
