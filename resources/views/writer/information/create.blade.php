@extends('layouts.writerDashboard')

@section('content')
    <div class="card card-primary card-outline m-4">
        <!--begin::Header-->
        <div class="card-header">
            <div class="card-title">Add Information</div>
            <div class="float-end">
                <a href="{{ route('writer.information.index') }}">
                    <i class="nav-icon bi bi-arrow-left"></i>
                </a>
            </div>
        </div>
        <!--end::Header-->

        <!--begin::Form-->
        <form action="{{ route('writer.information.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!--begin::Body-->
            <div class="card-body">
                <!-- Upload Gambar -->
                <div class="input-group mb-3">
                    <input type="file" id="inputGroupFile02" class="form-control @error('image') is-invalid @enderror"
                        name="image">
                    @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                </div>

                <!-- Judul -->
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                        id="title" placeholder="Title" required>
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Konten -->
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" id="content" rows="4"
                        placeholder="Content"></textarea>
                    @error('content')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Kategori -->
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select name="category_id" id="category_id"
                        class="form-control @error('category_id') is-invalid @enderror">
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Status -->
                {{-- <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div> --}}
            <!--end::Body-->

            <!--begin::Footer-->
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                <button type="reset" class="btn btn-sm btn-warning">Reset</button>
            </div>
            <!--end::Footer-->
        </form>
        <!--end::Form-->
    </div>
@endsection
