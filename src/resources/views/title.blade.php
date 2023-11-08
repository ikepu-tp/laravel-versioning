@props([
    'title' => null,
])
@if (!empty($title))
  <h3 class="border-bottom mt-4 mb-2 py-1">{{ __('versioning::versioning.' . $title) }}</h3>
@endif
