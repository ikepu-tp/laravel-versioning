@props([
    'name' => '',
    'count' => 0,
])

<div class="border rounded px-3 py-2 mb-2">
  入力欄の追加：
  <input type="number" name="add[{{ $name }}]" class="form-control w-auto d-inline-block"
    value="{{ $count }}">
  <button type="submit" name="add_button" class="btn btn-outline-secondary d-inline-block"
    value="{{ $name }}">追加</button>
</div>
