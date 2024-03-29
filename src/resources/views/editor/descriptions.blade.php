@props([
    'title' => null,
    'items' => [],
    'name' => '',
])
@include('LaravelVersioning::title', ['title' => $title])
@include('LaravelVersioning::editor.addButton', ['name' => $name])
<ul>
  @foreach ($items as $item)
    <li class="mb-2">
      <textarea name="{{ $name }}[]" class="form-control" style="width: 100%; height: auto;">{{ $item }}</textarea>
    </li>
  @endforeach
</ul>
