@props([
    'name' => '',
    'count' => 0,
])

<div style="border: 1px solid; border-radius: 5px; margin: 10px;padding: 10px;">
  入力欄の追加：
  <input type="number" name="add[{{ $name }}]" value="{{ $count }}">
  <button type="submit" name="add_button" value="{{ $name }}">追加</button>
</div>
