@extends('layouts.app')

@section("content")

<div class="container">
  <h1>Modifica il Progetto</h1>

  <form action="{{ route('admin.projects.update') }}" method="POST">
    @csrf()

    <div class="mb-3"><label class="form-label">Titolo</label><input type="text" class="form-control" name="title"></div>
    <div class="mb-3"><label class="form-label">Immagine</label><input type="text" class="form-control" name="image"></div>
    <div class="mb-3"><label class="form-label">Contenuto</label><textarea class="form-control" name="body"></textarea></div>

    <button class="btn btn-primary">Modifica</button>
  </form>
</div>

@endsection