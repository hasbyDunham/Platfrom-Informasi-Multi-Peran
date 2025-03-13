@extends('layouts.adminDashboard')

@section('content')
    <div class="container">
        <h2>Detail Information</h2>

        <div class="card">
            <div class="card-body">
                <h3>{{ $information->title }}</h3>
                <p><strong>Category:</strong> {{ $information->category->name }}</p>
                <p><strong>Author:</strong> {{ $information->user->name ?? 'Unknown' }}</p>
                <p><strong>Status:</strong>
                    @if ($information->approval_status == 'approved')
                        <span class="badge bg-success">Published</span>
                    @elseif ($information->approval_status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif ($information->approval_status == 'rejected')
                        <span class="badge bg-danger">Rejected</span>
                    @endif
                </p>
                <p><strong>Description:</strong></p>
                <p>{{ $information->content }}</p>
                <a href="{{ route('admin.information.index') }}" class="btn btn-secondary">Back</a>

                @if ($information->approval_status == 'pending')
                    <div class="text-end mt-2"> <!-- Membungkus tombol dengan div dan memberi class text-end -->
                        <form action="{{ route('admin.information.approve', $information->slug) }}" method="POST" class="d-inline-block me-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">
                                <i class="fa-solid fa-check"></i> Approve
                            </button>
                        </form>

                        <form action="{{ route('admin.information.reject', $information->slug) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger">
                                <i class="fa-solid fa-xmark"></i> Reject
                            </button>
                        </form>
                    </div>
                @endif

                {{-- <p>Slug: {{ $information->slug }}</p>
                <p>Route Approve: {{ route('admin.information.approve', $information->slug) }}</p>
                <p>Route Reject: {{ route('admin.information.reject', $information->slug) }}</p> --}}

            </div>
        </div>
    </div>
@endsection
