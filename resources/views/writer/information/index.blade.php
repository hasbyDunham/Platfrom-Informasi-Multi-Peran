@extends('layouts.writerDashboard')

@section('content')
    <div class="card m-4">
        <div class="card-header">
            <h3 class="card-title">information</h3>
            <div class="float-end">
                <a href="{{ route('writer.information.create') }}"><i class=" nav-icon bi bi-plus-lg"></i></a>
            </div>
        </div> <!-- /.card-header -->
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">No</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th style="text-align: end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $key => $information)
                        <tr class="align-middle">
                            <td>{{ $no++ }}</td>
                            {{-- <td>
                                <img src="{{ asset('/storage/information/' . $data->image) }}" class="rounded"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                            </td> --}}
                            <td>
                                <span class="text-toggle" onclick="toggleText(this)">
                                    {{ Str::limit($informaion->title, 25, ' ...') }}
                                </span>
                                <span class="full-text" style="display: none;">{{ $informaion->title }}</span>
                            </td>
                            <td>
                                <span class="text-toggle" onclick="toggleText(this)">
                                    {{ Str::limit($information->category->name, 80, ' ...') }}
                                </span>
                                <span class="full-text" style="display: none;">{{ $information->category->name }}</span>
                            </td>
                            <td>
                                <span class="text-toggle" onclick="toggleText(this)">
                                    {{ Str::limit($information->content, 80, ' ...') }}
                                </span>
                                <span class="full-text" style="display: none;">{{ $information->content }}</span>
                            </td>
                            <td>
                                <span class="text-toggle" onclick="toggleText(this)">
                                    {{ Str::limit($information->created_at->format('d-m-Y'), 80, ' ...') }}
                                </span>
                                <span class="full-text" style="display: none;">{{ $information->created_at->format('d-m-Y') }}</span>
                            </td>
                            <td style="width: 145px">
                                <form action="{{ route('writer.information.destroy', $informaion->id) }}" method="POST"
                                    class="float-end">
                                    @csrf
                                    @method('DELETE')
                                    {{-- <a href="{{ route('writer.information.show', $informaion->id) }}" class="btn btn-sm btn-dark">Show</a> | --}}
                                    <a href="{{ route('writer.information.edit', $informaion->id) }}"
                                        class="btn btn-sm btn-success">Edit</a>
                                    |
                                    <a href="{{ route('writer.information.destroy', $informaion->id) }}"
                                        class="btn btn-sm btn-danger" data-confirm-delete="true">Delete</a>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Data Data Belum Tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {!! $information->withQueryString()->links('pagination::bootstrap-4') !!}
        </div> <!-- /.card-body -->
    </div> <!-- /.card -->

    <script>
        function toggleText(element) {
            const fullTextElement = element.nextElementSibling; // Ambil elemen berikutnya yang merupakan teks penuh
            const isHidden = fullTextElement.style.display === 'none';

            // Tampilkan atau sembunyikan teks penuh
            if (isHidden) {
                fullTextElement.style.display = 'inline'; // Tampilkan teks penuh
                element.style.display = 'none'; // Sembunyikan teks terbatas
            } else {
                fullTextElement.style.display = 'none'; // Sembunyikan teks penuh
                element.style.display = 'inline'; // Tampilkan teks terbatas
            }
        }
    </script>
@endsection

@section('content')
    {{-- <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Information Management</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success mb-2" href="{{ route('writer.information.create') }}"><i class="fa fa-plus"></i>
                    Create New
                    Information</a>
            </div>
        </div>
    </div> --}}

    {{-- @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif --}}

    <table class="table table-bordered">
        {{-- <tr>
            <th>No</th>
            <th>Title</th>
            <th>Category</th>
            <th>Description</th>
            <th>Created At</th>
            <th width="280px">Action</th>
        </tr> --}}
        {{-- @foreach ($data as $key => $information)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $information->title }}</td>
                <td>{{ $information->category->name }}</td>
                <td>{{ Str::limit($information->content, 100) }}</td>
                <td>{{ $information->created_at->format('d-m-Y') }}</td>
                <td>
                    {{-- <a class="btn btn-info btn-sm" href="{{ route('writer.information.show', $information->id) }}"><i
                            class="fa-solid fa-eye"></i> Show</a> --}}
                    <a class="btn btn-warning btn-sm" href="{{ route('writer.information.edit', $information->slug) }}"><i
                            class="fa-solid fa-pen-to-square"></i> Edit</a>
                    <form method="POST" action="{{ route('writer.information.destroy', $information->slug) }}"
                        style="display:inline">
                        @csrf
                        @method('DELETE')

                        <a href="{{ route('writer.information.destroy', $information->slug) }}"
                            class="btn btn-sm btn-danger btn-sm" data-confirm-delete="true"><i
                                class="fa-solid fa-trash"></i>Delete</a>
                        {{-- <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i>
                            Delete</button> --}}
                    </form>
                </td>
            </tr>
        @endforeach --}}
    </table>

    {{-- {!! $data->links('pagination::bootstrap-5') !!} --}}

    {{-- <p class="text-center text-primary"><small>Tutorial by ItSolutionStuff.com</small></p> --}}
@endsection
