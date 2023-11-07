@props([
    'title' => null,
    'items' => null,
])
@if (is_array($items))
  @include('LaravelVersioning::title', ['title' => $title])
  <ul>
    @foreach ($items as $item)
      <li>{{ $item }}</li>
    @endforeach
  </ul>
@endif
