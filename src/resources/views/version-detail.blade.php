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
  <span>{{ __('versioning::versioning.created at') }}: {{ $version['createdDate'] }}</span>
  <span>{{ __('versioning::versioning.released at') }}: {{ $version['releaseDate'] }}</span>
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
      @include('LaravelVersioning::title', ['title' => 'authors'])
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
                <a href="{{ $author['homepage'] }}" target="_blank" rel="noopener noreferrer" class="ms-2">
                  {{ __('versioning::versioning.homepage') }}
                </a>
              @endisset
              @isset($author['email'])
                <a href="mailto:{{ $author['email'] }}" target="_blank" rel="noopener noreferrer" class="ms-2">
                  {{ __('versioning::versioning.email') }}
                </a>
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
      'title' => 'description',
      'items' => $version['description'],
  ])
  @include('LaravelVersioning::descriptions', [
      'title' => 'newFeatures',
      'items' => $version['newFeatures'],
  ])
  @include('LaravelVersioning::descriptions', [
      'title' => 'changedFeatures',
      'items' => $version['changedFeatures'],
  ])
  @include('LaravelVersioning::descriptions', [
      'title' => 'deletedFeatures',
      'items' => $version['deletedFeatures'],
  ])
  @include('LaravelVersioning::descriptions', [
      'title' => 'notice',
      'items' => $version['notice'],
  ])
  @include('LaravelVersioning::descriptions', [
      'title' => 'security',
      'items' => $version['security'],
  ])
  @include('LaravelVersioning::descriptions', [
      'title' => 'futurePlans',
      'items' => $version['futurePlans'],
  ])
  @include('LaravelVersioning::descriptions', [
      'title' => 'note',
      'items' => $version['note'],
  ])
</div>
