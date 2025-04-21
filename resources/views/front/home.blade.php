@extends('layouts.homePage')
@section('Content')
    <!-- Trending Category Section -->
    <section id="trending-category" class="trending-category section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="container" data-aos="fade-up">
                <div class="row g-5">
                    <div class="col-lg-4">

                        @if ($mainNews)
                            <div class="post-entry lg">
                                @if ($mainNews->image)
                                    <a href="{{ route('detail', $mainNews->slug) }}">
                                        <img src="{{ asset($mainNews->image) }}" alt="{{ $mainNews->title }}"
                                            class="img-fluid mb-2">
                                    </a>
                                @endif

                                <div class="post-meta">
                                    <span class="date">{{ $mainNews->category->name ?? 'Uncategorized' }}</span>
                                    <span class="mx-1">•</span>
                                    <span>{{ $mainNews->created_at->format("M jS 'y") }}</span>
                                </div>

                                <h2><a href="{{ route('detail', $mainNews->slug) }}">{{ $mainNews->title }}</a></h2>
                                <p class="mb-4 d-block">{{ Str::limit(strip_tags($mainNews->content), 200) }}</p>
                            </div>
                        @endif

                    </div>

                    <div class="col-lg-8">
                        <div class="row g-5">

                            @php
                                $half = ceil($otherNews->count() / 2);
                                $chunks = $otherNews->chunk($half);
                            @endphp

                            @foreach ($chunks as $chunk)
                                <div class="col-lg-6 border-start custom-border">
                                    @foreach ($chunk as $news)
                                        <div class="post-entry">
                                            <a href="{{ route('detail', $news->slug) }}">
                                                <img src="{{ asset($news->image) }}" alt="{{ $news->title }}"
                                                    class="img-fluid">
                                            </a>
                                            <div class="post-meta">
                                                <span class="date">{{ $news->category->name ?? 'Uncategorized' }}</span>
                                                <span class="mx-1">•</span>
                                                <span>{{ $news->created_at->format("M jS 'y") }}</span>
                                            </div>
                                            <h2><a href="{{ route('detail', $news->slug) }}">{{ $news->title }}</a></h2>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach

                        </div>
                    </div>

                </div> <!-- End .row -->
            </div>

        </div>

    </section>
    <!-- /Trending Category Section -->
@endsection



<!-- Trending Section -->
{{-- <div class="col-lg-4">

<div class="trending">
<h3>Trending</h3>
<ul class="trending-post">
<li>
<a href="blog-details.html">
<span class="number">1</span>
<h3>The Best Homemade Masks for Face (keep the Pimples Away)</h3>
<span class="author">Jane Cooper</span>
</a>
</li>
<li>
<a href="blog-details.html">
<span class="number">2</span>
<h3>17 Pictures of Medium Length Hair in Layers That Will Inspire Your New Haircut</h3>
<span class="author">Wade Warren</span>
</a>
</li>
<li>
<a href="blog-details.html">
<span class="number">3</span>
<h3>13 Amazing Poems from Shel Silverstein with Valuable Life Lessons</h3>
<span class="author">Esther Howard</span>
</a>
</li>
<li>
<a href="blog-details.html">
<span class="number">4</span>
<h3>9 Half-up/half-down Hairstyles for Long and Medium Hair</h3>
<span class="author">Cameron Williamson</span>
</a>
</li>
<li>
<a href="blog-details.html">
<span class="number">5</span>
<h3>Life Insurance And Pregnancy: A Working Mom’s Guide</h3>
<span class="author">Jenny Wilson</span>
</a>
</li>
</ul>
</div>

</div> --}}
<!-- End Trending Section -->
