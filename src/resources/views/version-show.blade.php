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
  @include('LaravelVersioning::version-detail', ['version' => $version])
@endsection
