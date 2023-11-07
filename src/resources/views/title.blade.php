@props([
    'title' => null,
])
@if (!empty($title))
  <h3 class="border-bottom mt-4 mb-2 py-1">{{ $title }}</h3>
@endif
