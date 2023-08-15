{{-- // @formatter:off --}}
@props(['dot' => false, 'comma' => false])

<a {{ $attributes->merge(['class' => 'text-blue-600 hover:text-blue-600 dark:text-white dark:hover:text-slate-100']) }}>{{ $slot }}</a>@if($dot).@elseif($comma),@endif
