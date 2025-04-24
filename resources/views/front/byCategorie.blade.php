@extends('layouts.homePage')

@section('Content')
<section id="culture-category" class="culture-category section">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <div class="section-title-container d-flex align-items-center justify-content-between">
            <h2>{{ $category->name }}</h2>
            {{-- <p><a href="{{ route('information.byCategory', $category->slug) }}">Lihat Semua {{ $category->name }}</a> --}}
            </p>
        </div>
    </div>
    <!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row">
            <div class="col-md-9">
                @if($informations->count())
                {{-- Highlight First Post --}}
                @php $first = $informations->first(); @endphp
                <div class="d-lg-flex post-entry mb-4">
                    @if($first->image)
                    <a href="{{ route('detail', $first->slug) }}" class="me-4 thumbnail mb-4 mb-lg-0 d-inline-block">
                        <img src="{{ asset($first->image) }}" alt="{{ $first->title }}" class="img-fluid">
                    </a>
                    @endif
                    <div>
                        <div class="post-meta">
                            <span class="date">{{ $category->name }}</span>
                            <span class="mx-1">•</span>
                            <span>{{ $first->created_at->format('M jS \'y') }}</span>
                        </div>
                        <h3><a href="{{ route('detail', $first->slug) }}">{{ $first->title }}</a></h3>
                        <p>{{ Str::limit(strip_tags($first->content), 150) }}</p>
                    </div>
                </div>

                {{-- Remaining Posts --}}
                <div class="row">
                    @foreach($informations->skip(1)->take(3) as $info)
                    <div class="col-lg-4 mb-4">
                        <div class="post-list border-bottom">
                            @if($info->image)
                            <a href="{{ route('detail', $info->slug) }}">
                                <img src="{{ asset($info->image) }}" alt="{{ $info->title }}" class="img-fluid">
                            </a>
                            @endif

                            <div class="post-meta">
                                <span class="date">{{ $category->name }}</span>
                                <span class="mx-1">•</span>
                                <span>{{ $info->created_at->format('M jS \'y') }}</span>
                            </div>
                            <h2 class="mb-2">
                                <a href="{{ route('detail', $info->slug) }}">{{ $info->title }}</a>
                            </h2>
                            <span class="author mb-3 d-block">{{ $info->author ?? 'Admin' }}</span>
                            <p class="mb-4 d-block">{{ Str::limit(strip_tags($info->content), 100) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p>Belum ada informasi untuk kategori ini.</p>
                @endif
            </div>

            {{-- Sidebar Posts --}}
            <div class="col-md-3">
                @foreach($informations->skip(4)->take(6) as $info)
                <div class="post-list border-bottom mb-3">
                    <div class="post-meta">
                        <span class="date">{{ $category->name }}</span>
                        <span class="mx-1">•</span>
                        <span>{{ $info->created_at->format('M jS \'y') }}</span>
                    </div>
                    <h2 class="mb-2">
                        <a href="{{ route('detail', $info->slug) }}">{{ $info->title }}</a>
                    </h2>
                    <span class="author mb-3 d-block">{{ $info->author ?? 'Admin' }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="mt-4">
            {{ $informations->links() }}
        </div>
    </div>
</section>

@endsection
