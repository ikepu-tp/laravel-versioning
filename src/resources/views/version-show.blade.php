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
@extends('LaravelVersioning::layout')
@section('content')
  <h2>{{ $version['version'] }}</h2>
  <a href="javascript:void()" onclick="history.back()">戻る</a>
  @include('LaravelVersioning::version-detail', ['version' => $version])
@endsection
