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
  @if (session('status'))
    <div>
      {{ session('status') }}
    </div>
  @endif
  <form
    action="{{ is_null($version['version']) ? route('version.editor.store') : route('version.editor.update', ['editor' => $version['version']]) }}"
    method="post">
    @csrf
    @if (is_null($version['version']))
      @method('POST')
    @else
      @method('PUT')
    @endif
    <h2>{{ $version['version'] ?: '新規追加' }}</h2>
    <a href="{{ route('version.editor.index') }}">戻る</a>
    <div class="input-group my-2">
      <div class="input-group-text">
        {{ __('versioning::versioning.created at') }}:
      </div>
      <input type="date" name="createdDate" class="form-control" value="{{ $version['createdDate'] }}" required>
      <div class="input-group-text">{{ __('versioning::versioning.released at') }}:
      </div>
      <input type="date" name="releaseDate" class="form-control" value="{{ $version['releaseDate'] }}" required>
    </div>
    <div>
      <div>
        @include('LaravelVersioning::title', ['title' => 'authors'])
        @include('LaravelVersioning::editor.addButton', ['name' => 'authors'])
        <ul>
          @foreach ($version['authors'] as $key => $author)
            <li class="mb-2">
              <div class="input-group">
                <label class="input-group-text">
                  {{ __('versioning::versioning.author_name') }}：
                </label>
                <input type="text" name="authors[{{ $key }}][name]" class="form-control"
                  value="{{ is_string($author) ? $author : (isset($author['name']) ? $author['name'] : '') }}">
              </div>
              <div class="input-group">
                <label class="input-group-text">
                  {{ __('versioning::versioning.homepage') }}：
                </label>
                <input type="url" name="authors[{{ $key }}][homepage]" class="form-control"
                  value="{{ isset($author['homepage']) ? $author['homepage'] : '' }}">
              </div>
              <div class="input-group">
                <label class="input-group-text">
                  {{ __('versioning::versioning.email') }}：
                </label>
                <input type="email" name="authors[{{ $key }}][email]" class="form-control"
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
              <input type="url" name="url[]" class="form-control" value="{{ $url }}">
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
    <button type="submit" class="btn btn-primary">登録</button>
  </form>
@endsection
