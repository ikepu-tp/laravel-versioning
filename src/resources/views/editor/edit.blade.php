@props([
    'version' => [
        'version' => null,
        'releaseDate' => null,
        'createdDate' => null,
        'authors' => [],
        'url' => [],
        'description' => [],
        'newFeatures' => [],
        'changedFeatures' => [],
        'deletedFeatures' => [],
        'notice' => [],
        'security' => [],
        'futurePlans' => [],
        'note' => [],
    ],
])
@extends('LaravelVersioning::layout')
@section('content')
  <form
    action="{{ is_null($version['version']) ? route('version.editor.store') : route('version.editor.update', ['editor' => $version['version']]) }}"
    method="post">
    @csrf
    @if (is_null($version['version']))
      @method('POST')
    @else
      @method('PUT')
    @endif
    <h2>{{ $version['version'] }}</h2>@props([
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
      <span>{{ __('versioning::versioning.created at') }}:
        <input type="date" name="createdDate" value="{{ $version['createdDate'] }}" required>
      </span>
      <span>{{ __('versioning::versioning.released at') }}:
        <input type="date" name="releaseDate" value="{{ $version['releaseDate'] }}" required>
      </span>
    </div>
    <div>
      <div>
        @include('LaravelVersioning::title', ['title' => 'authors'])
        @include('LaravelVersioning::editor.addButton', ['name' => 'authors'])
        <ul>
          @foreach ($version['authors'] as $author)
            <li>
              <div>
                {{ __('versioning::versioning.author_name') }}：<input type="text" name="authors[][name]"
                  value="{{ is_string($author) ? $author : (isset($author['name']) ? $author['name'] : '') }}">
              </div>
              <div>
                {{ __('versioning::versioning.homepage') }}：
                <input type="text" name="authors[][homepage]"
                  value="{{ isset($author['homepage']) ? $author['homepage'] : '' }}">
              </div>
              <div>
                {{ __('versioning::versioning.email') }}：
                <input type="email" name="authors[][email]"
                  value="{{ isset($author['email']) ? $author['email'] : '' }}">
              </div>
            </li>
          @endforeach
        </ul>
      </div>
      <div>
        @include('LaravelVersioning::title', ['title' => 'URL'])
        @include('LaravelVersioning::editor.addButton', ['name' => 'url'])
        <ul>
          @foreach ($version['url'] as $url)
            <li>
              <input type="url" name="url[]" value="{{ $url }}">
            </li>
          @endforeach
        </ul>
      </div>
    </div>
    <div>
      @include('LaravelVersioning::editor.descriptions', [
          'title' => 'description',
          'items' => $version['description'],
          'name' => 'description',
      ])
      @include('LaravelVersioning::editor.descriptions', [
          'title' => 'newFeatures',
          'items' => $version['newFeatures'],
          'name' => 'newFeatures',
      ])
      @include('LaravelVersioning::editor.descriptions', [
          'title' => 'changedFeatures',
          'items' => $version['changedFeatures'],
          'name' => 'changedFeatures',
      ])
      @include('LaravelVersioning::editor.descriptions', [
          'title' => 'deletedFeatures',
          'items' => $version['deletedFeatures'],
          'name' => 'deletedFeatures',
      ])
      @include('LaravelVersioning::editor.descriptions', [
          'title' => 'notice',
          'items' => $version['notice'],
          'name' => 'notice',
      ])
      @include('LaravelVersioning::editor.descriptions', [
          'title' => 'security',
          'items' => $version['security'],
          'name' => 'security',
      ])
      @include('LaravelVersioning::editor.descriptions', [
          'title' => 'futurePlans',
          'items' => $version['futurePlans'],
          'name' => 'futurePlans',
      ])
      @include('LaravelVersioning::editor.descriptions', [
          'title' => 'note',
          'items' => $version['note'],
          'name' => 'note',
      ])
    </div>
    <button type="submit">登録</button>
  </form>
@endsection
