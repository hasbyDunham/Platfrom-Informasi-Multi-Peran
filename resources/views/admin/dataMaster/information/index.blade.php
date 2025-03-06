@extends('layouts.adminDashboard')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Information Management</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success mb-2" href="{{ route('admin.information.create') }}"><i class="fa fa-plus"></i>
                    Create New
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
            <th>Created By</th>
            {{-- <th>Created At</th> --}}
            <th>Status</th>
            <th width="125px">Action</th>
        </tr>
        @foreach ($data as $key => $information)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $information->title }}</td>
                <td>{{ $information->category->name }}</td>
                <td>{{ Str::limit($information->content, 100) }}</td>
                <td>{{ $information->user->name ?? 'Unknown' }}</td> <!-- Menampilkan nama user -->
                {{-- <td>{{ $information->created_at->format('d-m-Y') }}</td> --}}
                <td>
                    @if ($information->approval_status == 'approved')
                        <span class="badge bg-success">Published</span>
                    @elseif ($information->approval_status == 'pending')
                        <span class="badge bg-warning">Draft</span>
                    @elseif ($information->approval_status == 'rejected')
                        <span class="badge bg-danger">Rejected</span>
                    @endif
                </td>
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('admin.information.show', $information->slug) }}"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Show">
                        <i class="fa-solid fa-eye"></i>
                    </a>

                    <a class="btn btn-warning btn-sm" href="{{ route('admin.information.edit', $information->slug) }}"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>

                    <form method="POST" action="{{ route('admin.information.destroy', $information->slug) }}"
                        style="display:inline">
                        @csrf
                        @method('DELETE')

                        <a href="{{ route('admin.information.destroy', $information->slug) }}"
                            class="btn btn-sm btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Delete" data-confirm-delete="true">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </form>
                </td>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                            return new bootstrap.Tooltip(tooltipTriggerEl);
                        });
                    });
                </script>

            </tr>
        @endforeach
    </table>

    {!! $data->links('pagination::bootstrap-5') !!}

    <p class="text-center text-primary"><small>Tutorial by ItSolutionStuff.com</small></p>
@endsection
