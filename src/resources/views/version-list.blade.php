@props([
    'versions' => [],
])
<ul>
  @foreach ($versions as $version)
    @php
      if (isset($version['path'])) {
          $version = ikepu_tp\LaravelVersioning\app\Services\VersionFileService::getJson(base_path($version['path']));
      }
    @endphp
    <li>
      <a href="{{ route('version.show', ['version' => $version['version']]) }}">{{ $version['version'] }}</a>
    </li>
  @endforeach
</ul>
