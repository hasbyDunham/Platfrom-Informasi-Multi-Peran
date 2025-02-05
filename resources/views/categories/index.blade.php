@extends('layouts.adminDashboard')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Categories Management</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success mb-2" href="{{ route('categorie.create') }}"><i class="fa fa-plus"></i> Create New
                    categorie</a>
            </div>
        </div>
    </div>

    @session('success')
        <div class="alert alert-success" categorie="alert">
            {{ $value }}
        </div>
    @endsession

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Description</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($data as $key => $categorie)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $categorie->name }}</td>
                <td>{{ $categorie->description }}</td>
                <td>
                    {{-- <a class="btn btn-info btn-sm" href="{{ route('categorie.show',$categorie->id) }}"><i class="fa-solid fa-list"></i> Show</a> --}}
                    <a class="btn btn-warning btn-sm" href="{{ route('categorie.edit', $categorie->id) }}"><i
                            class="fa-solid fa-pen-to-square"></i> Edit</a>
                    <form method="POST" action="{{ route('categorie.destroy', $categorie->id) }}" style="display:inline">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i>
                            Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {!! $data->links('pagination::bootstrap-5') !!}

    <p class="text-center text-primary"><small>Tutorial by ItSolutionStuff.com</small></p>
@endsection
