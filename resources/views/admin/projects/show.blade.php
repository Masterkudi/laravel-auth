@extends('layouts.app')

@section("content")

<div class="container">
  <h1>{{ $project->title }}</h1>
  <small>Data pubblicazione: {{ $project->published_at?->format("d/m/Y H:i") }}</small>

  <img src="{{ $project->image }}" alt="" class="img-fluid">

  <p>{{ $project->body }}</p>
</div>

@endsection