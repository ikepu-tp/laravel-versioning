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
              @include('LaravelVersioning::descriptions', [
                  'title' => '寄与者',
                  'items' => $version['Author'],
              ])
              @if (is_array($version['url']))
                <div>
                  @include('LaravelVersioning::title', ['title' => 'URL'])
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
              @include('LaravelVersioning::descriptions', [
                  'title' => '説明',
                  'items' => $version['description'],
              ])
              @include('LaravelVersioning::descriptions', [
                  'title' => '新機能',
                  'items' => $version['newFeatures'],
              ])
              @include('LaravelVersioning::descriptions', [
                  'title' => '変更機能',
                  'items' => $version['changedFeatures'],
              ])
              @include('LaravelVersioning::descriptions', [
                  'title' => '削除機能',
                  'items' => $version['deletedFeatures'],
              ])
              @include('LaravelVersioning::descriptions', [
                  'title' => '注意事項',
                  'items' => $version['notice'],
              ])
              @include('LaravelVersioning::descriptions', [
                  'title' => 'セキュリティ',
                  'items' => $version['security'],
              ])
              @include('LaravelVersioning::descriptions', [
                  'title' => '今後の予定',
                  'items' => $version['futurePlans'],
              ])
              @include('LaravelVersioning::descriptions', [
                  'title' => 'お知らせ',
                  'items' => $version['note'],
              ])
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endsection
