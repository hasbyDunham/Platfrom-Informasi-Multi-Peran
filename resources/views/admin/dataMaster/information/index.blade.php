@extends('layouts.adminDashboard')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Information Management</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success mb-2" href="{{ route('admin.information.create') }}"><i class="fa fa-plus"></i> Create New
                    Information</a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Title</th>
            <th>Category</th>
            <th>Description</th>
            <th>Created At</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($data as $key => $information)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $information->title }}</td>
                <td>{{ $information->category->name }}</td>
                <td>{{ Str::limit($information->description, 100) }}</td>
                <td>{{ $information->created_at->format('d-m-Y') }}</td>
                <td>
                    {{-- <a class="btn btn-info btn-sm" href="{{ route('information.show', $information->id) }}"><i
                            class="fa-solid fa-eye"></i> Show</a> --}}
                    <a class="btn btn-warning btn-sm" href="{{ route('admin.information.edit', $information->slug) }}"><i
                            class="fa-solid fa-pen-to-square"></i> Edit</a>
                    <form method="POST" action="{{ route('admin.information.destroy', $information->slug) }}"
                        style="display:inline">
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
