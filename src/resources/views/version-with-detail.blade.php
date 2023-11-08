@props([
    'versions' => [],
])
<div class="accordion" id="versions">
  @foreach ($versions as $version)
    @php
      if (isset($version['path'])) {
          $version = ikepu_tp\LaravelVersioning\app\Services\VersionFileService::getJson(base_path($version['path']));
      }
    @endphp
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
          data-bs-target="#v{{ $version['version'] }}-body" aria-expanded="false"
          aria-controls="v{{ $version['version'] }}-body">
          v{{ $version['version'] }}
        </button>
      </h2>
      <div id="v{{ $version['version'] }}-body" class="accordion-collapse collapse" data-bs-parent="#versions">
        <div class="accordion-body">
          @include('LaravelVersioning::version-detail', ['version' => $version])
        </div>
      </div>
    </div>
  @endforeach
</div>
