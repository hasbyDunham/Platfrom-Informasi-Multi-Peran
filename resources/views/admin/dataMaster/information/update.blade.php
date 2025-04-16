@extends('layouts.adminDashboard')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Information</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm mb-2" href="{{ route('admin.information.index') }}">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.information.update', $information->slug) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <!-- Title -->
        <div class="col-md-12">
            <div class="form-group">
                <strong>Title:</strong>
                <input type="text" name="title" class="form-control" value="{{ old('title', $information->title) }}" required>
            </div>
        </div>

        <!-- Content -->
        <div class="col-md-12">
            <div class="form-group">
                <strong>Content:</strong>
                <textarea class="form-control" name="content" rows="3" required>{{ old('content', $information->content) }}</textarea>
            </div>
        </div>

        <!-- Category -->
        <div class="col-md-12">
            <div class="form-group">
                <strong>Category:</strong>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $information->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Image -->
        <div class="col-md-12">
            <div class="form-group">
                <strong>Current Image:</strong><br>
                @if($information->image)
                    <img src="{{ asset('storage/' . $information->image) }}" alt="Image" width="150">
                @endif
                <input type="file" name="image" class="form-control mt-2">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="col-md-12 text-center mt-3">
            <button type="submit" class="btn btn-primary btn-sm mb-3">
                <i class="fa-solid fa-floppy-disk"></i> Update
            </button>
        </div>
    </div>
</form>
@endsection
