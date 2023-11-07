@props([
    'versions' => [],
])
@extends('LaravelVersioning::layout')
@section('content')
  <div class="accordion" id="versions">
    @foreach ($versions as $version)
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
            <div>
              <span>作成日：{{ $version['createdDate'] }}</span>
              <span>リリース日：{{ $version['releaseDate'] }}</span>
            </div>
            <div>
              <div>
                リリース寄与者
                <ul>
                  @foreach ($version['Author'] as $author)
                    <li>{{ $author }}</li>
                  @endforeach
                </ul>
              </div>
              @if (!empty($version['url']))
                <div>
                  参考URL
                  <ul>
                    @foreach ($version['url'] as $url)
                      <li>
                        <a href="{{ $url }}" target="_blank">{{ $url }}</a>
                      </li>
                    @endforeach
                  </ul>
                </div>
              @endif
            </div>
            <div>
              <h3>説明</h3>
              {{ $version['description'] }}
              <h3>新機能</h3>
              {{ $version['newFeatures'] }}
              <h3>変更機能</h3>
              {{ $version['changedFeatures'] }}
              <h3>削除機能</h3>
              {{ $version['deletedFeatures'] }}
              <h3>注意事項</h3>
              {{ $version['notice'] }}
              <h3>セキュリティ</h3>
              {{ $version['security'] }}
              <h3>今後の予定</h3>
              {{ $version['futurePlans'] }}
              <h3>お知らせ</h3>
              {{ $version['note'] }}
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endsection
