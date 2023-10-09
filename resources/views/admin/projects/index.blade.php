@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Lista dei miei Progetti</h1>

        <div class="bg-light my-2">
            <a href="{{ route('admin.projects.create') }}" class="btn btn-link">Nuovo post</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <td>Titolo</td>
                    <td>Immagine</td>
                    <td>Data Pubblicazione</td>
                    <td></td>
                </tr>
            </thead>

            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td>{{ $project->title }}</td>
                        <td>{{ $project->image }}</td>
                        <td>{{ $project->published_at?->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.projects.show', $project->slug) }}" class="btn btn-info">Details</a>
                            <a href="{{ route('admin.projects.edit', $project->slug) }}" class="btn btn-warning">Update</a>

                          {{-- form per il delete --}}
                          <form action="{{ route('admin.projects.destroy', $project->slug)}}" method="POST">
                            @csrf()
                            @method('DELETE')

                          <button class="btn btn-danger">Elimina</button>
                          </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
