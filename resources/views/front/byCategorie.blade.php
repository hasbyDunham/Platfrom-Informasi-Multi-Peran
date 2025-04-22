@extends('layouts.homePage')

@section('Content')
    <section class="section">
        <div class="container">
            <h2 class="mb-4">Informasi Kategori: {{ $category->name }}</h2>

            <div class="row">
                @forelse ($informations as $info)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            @if ($info->image)
                                <img src="{{ asset($info->image) }}" class="card-img-top" alt="{{ $info->title }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $info->title }}</h5>
                                <p class="card-text">{{ Str::limit(strip_tags($info->content), 100) }}</p>
                                <a href="{{ route('detail', $info->slug) }}" class="btn btn-primary">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Belum ada informasi untuk kategori ini.</p>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $informations->links() }}
            </div>
        </div>
    </section>
@endsection
