@props([
    'versions' => [],
    'type' => 'version-list',
])
@extends('LaravelVersioning::layout')
@section('content')
  <table>
    <thead>
      <tr>
        <th>バージョン</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($versions as $version)
        @php
          if (isset($version['path'])) {
              $version = ikepu_tp\LaravelVersioning\app\Services\VersionFileService::getJson(base_path($version['path']));
          }
        @endphp
        <tr>
          <td>
            {{ $version['version'] }}
          </td>
          <td>
            <a href="{{ route('version.editor.show', ['editor' => $version['version']]) }}">詳細</a>
            <a href="{{ route('version.editor.edit', ['editor' => $version['version']]) }}">編集</a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
