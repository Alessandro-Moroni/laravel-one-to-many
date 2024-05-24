@extends('layouts.admin')

@section('content')

<div class="p-3 projects">
    <h2>Projects</h2>

    <div class="table-projects">


        @if ($errors->any())
        <div class="alert alert-danger" role="alert">

            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
        @endif

        @if (session('error'))

        <div class="alert alert-danger" role="alert">
            {{session('error')}}
        </div>
        @endif

        @if (session('success'))

        <div class="alert alert-success" role="alert">
            {{session('success')}}
        </div>
        @endif

        <div>
            <form action="{{ route('admin.projects.store') }}" method="POST" class="d-flex my-3 ">
                @csrf
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="title">
                <button class="btn btn-outline-success" type="submit">Add</button>
            </form>

        </div>

        <table class="table">
            <thead>
              <tr>
                <th scope="col">Title</th>
                <th scope="col">Type</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)

                <tr>
                  <td>
                    <form action="{{ route('admin.projects.update', $project) }}" method="POST" id="form-projects{{$project->id}}">
                        @csrf
                        @method('PUT')
                        <input type="text" value="{{ $project->title }}" name="title">

                    </form>
                  </td>

                  <td>
                    {{ $project->type->title }}
                  </td>

                  <td class="d-flex">
                    <button type="button" class="btn btn-primary me-2 " onclick="submitForm({{$project->id}})">
                        <i class="fa-solid fa-pen"></i>
                    </button>

                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Are you sure want to delete?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                  </td>
                </tr>
                @endforeach

            </tbody>
        </table>

    </div>

</div>

<script>

    function submitForm(id){
        const form = document.getElementById(`form-projects${id}`);
        form.submit();
    }


</script>

@endsection
