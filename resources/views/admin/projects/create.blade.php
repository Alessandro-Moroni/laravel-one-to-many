@extends('layouts.admin')

@section('content')

<div class="p-3 projects">
    <h2>New Projects</h2>

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

    <div class="table-projects">

        <form action="{{ route('admin.projects.store') }}" method="POST" class="d-flex my-3 ">
            @csrf
            <input class="form-control me-2 " name="title" type="text" id="title"  placeholder="Create" aria-label="Search" name="title">

            <button class="btn btn-success me-3" type="submit">Add project</button>
            <button type="reset" class="btn btn-danger">Reset</button>


        </form>




    </div>

</div>



@endsection
