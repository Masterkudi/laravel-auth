@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Nuovo Progetto</h1>

        {{-- Variabile $errors che va a ciclare su ogni errore e poi li stampa --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf()

            <div class="mb-3"><label class="form-label">Titolo</label>
                <input type="text" class="form-control"name="title">
            </div>

            <div class="mb-3"><label class="form-label">Immagine</label>
                <input type="file" accept="image/*" class="form-control"name="image">
            </div>

            <div class="mb-3"><label class="form-label">Contenuto</label>
                <textarea class="form-control" name="body"></textarea>
            </div>

            <button class="btn btn-primary">Salva</button>
        </form>
    </div>

@endsection
