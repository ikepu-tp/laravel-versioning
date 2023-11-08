@props([
    'version' => [
        'version' => null,
        'releaseDate' => null,
        'createdDate' => null,
        'authors' => null,
        'url' => null,
        'description' => null,
        'newFeatures' => null,
        'changedFeatures' => null,
        'deletedFeatures' => null,
        'notice' => null,
        'security' => null,
        'futurePlans' => null,
        'note' => null,
    ],
])
<div>
  <span>作成日：{{ $version['createdDate'] }}</span>
  <span>リリース日：{{ $version['releaseDate'] }}</span>
</div>
<div>
  @php
    $authors = null;
    if (isset($version['authors'])) {
        $authors = $version['authors'];
    }
    if (isset($version['Author'])) {
        $authors = $version['Author'];
    }
  @endphp
  @if (!empty($authors))
    <div>
      @include('LaravelVersioning::title', ['title' => '寄与者'])
      <ul>
        @foreach ($authors as $author)
          <li>
            @if (is_string($author))
              {{ $author }}
            @else
              @isset($author['name'])
                {{ $author['name'] }}
              @endisset
              @isset($author['homepage'])
                <a href="{{ $author['homepage'] }}" target="_blank" rel="noopener noreferrer">Link</a>
              @endisset
              @isset($author['email'])
                <a href="mailto:{{ $author['email'] }}" target="_blank" rel="noopener noreferrer">E-mail</a>
              @endisset
            @endif
          </li>
        @endforeach
      </ul>
    </div>
  @endif
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
