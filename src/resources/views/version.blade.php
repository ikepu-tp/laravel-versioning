@props([
    'versions' => [],
    'type' => 'version-list',
])
@extends('LaravelVersioning::layout')
@section('content')
  @include("LaravelVersioning::{$type}", ['versions' => $versions])
@endsection
