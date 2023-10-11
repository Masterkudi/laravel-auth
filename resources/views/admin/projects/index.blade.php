@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Lista dei miei Progetti</h1>

        <div class="bg-light my-2">
            <a href="{{ route('admin.projects.create') }}" class="btn btn-link">Nuovo post</a>
        </div>
        <div class="projectGallery">
            <div class="row row-cols-6 g-4 justify-content-center">
                @foreach ($projects as $project)
                    {{--
                    <tr>
                        <td>{{ $project->title }}</td>
                        <td><img src={{ asset('/storage/' . $project->image) }} class="img-thumbnail" style="width: 70px">
                        </td>
                        <td>{{ $project->published_at?->format('d/m/Y H:i') }}</td>
                        <td class=" text-center">
                            <a href="{{ route('admin.projects.show', $project->slug) }}" class="btn btn-info"><i
                                    class="fa-solid fa-circle-info"></i></a>
                        </td>
                        <td class=" text-center">
                            <a href="{{ route('admin.projects.edit', $project->slug) }}" class="btn btn-warning"><i
                                    class="fa-solid fa-pen-to-square"></i></a>
                        </td>
                        <td class=" text-center">
                            {{-- form per il delete 
                            <form action="{{ route('admin.projects.destroy', $project->slug) }}" method="POST">
                                @csrf()
                                @method('DELETE')
                                <button class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                            </form>
                        </td>
                    </tr>
                    --}}
                    <div class="col p-4">
                        <div class="card p-3">
                            <div>
                                <img src={{ asset('/storage/' . $project->image) }} class="img-thumbnail" style="width: 300px">
                            </div>
                            <div class="card-body bg-white text-center">
                                    <div>{{ $project->title }}</div>
                                    <div>{{ $project->published_at?->format('d/m/Y H:i') }}</div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="p-2">
                                    <a href="{{ route('admin.projects.show', $project->slug) }}" class="btn btn-info"><i class="fa-solid fa-circle-info"></i></a>
                                </div>
                                <div class="p-2">
                                    <a href="{{ route('admin.projects.edit', $project->slug) }}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                </div>
                                <div class="p-2">
                                    <form action="{{ route('admin.projects.destroy', $project->slug) }}" method="POST">
                                        @csrf()
                                        @method('DELETE')
                                        <a class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
