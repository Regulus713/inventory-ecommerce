@props(['status'])

@if ($status)
    <div {!! $attributes->merge(['class' => 'alert alert-success']) !!} x-data="{ show: true }" x-show="show" x-transition>
        {{ $status }}
    </div>
@endif
