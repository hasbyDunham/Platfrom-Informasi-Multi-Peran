@extends('layouts.homePage')
@section('Content')
<!-- Page Title -->
<div class="page-title">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">{{ $information->title }}</h1>
        <nav class="breadcrumbs">
            <ol>
                <li><a href={{ url('/') }}>Beranda</a></li>
                <li class="current">Unggahan</li>
            </ol>
        </nav>
    </div>
</div>
<!-- End Page Title -->

<div class="container">
    <div class="row">

        <div class="col-lg-8">

            <!-- Blog Details Section -->
            <section id="blog-details" class="blog-details section">
                <div class="container">
                    <article class="article">

                        @if ($information->image)
                        <div class="post-img">
                            <img src="{{ asset('storage/' . $information->image) }}" alt="{{ $information->title }}"
                                class="img-fluid">
                        </div>
                        @endif

                        <h2 class="title">{{ $information->title }}</h2>

                        <div class="meta-top">
                            <ul>
                                <li class="d-flex align-items-center">
                                    <i class="bi bi-person"></i>
                                    <a href="#">{{ $information->user->name }}</a>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="bi bi-clock"></i>
                                    <a href="#"><time datetime="{{ $information->created_at->toDateString() }}">
                                            {{ $information->created_at->format('M d, Y') }}
                                        </time></a>
                                </li>
                                {{-- <li class="d-flex align-items-center">
                                    <i class="bi bi-eye"></i> <span>{{ $information->views ?? '0' }} Views</span>
                                </li> --}}
                            </ul>
                        </div><!-- End meta top -->

                        <div class="content">
                            {!! nl2br(e($information->content)) !!}
                        </div><!-- End post content -->

                        <div class="meta-bottom mt-4">
                            <i class="bi bi-folder"></i>
                            <ul class="cats d-inline">
                                <li><a href="#">{{ $information->category->name }}</a></li>
                            </ul>
                        </div><!-- End meta bottom -->

                    </article>
                </div>
            </section>
            <!-- /Blog Details Section -->


            <!-- Blog Comments Section -->
            <section id="blog-comments" class="blog-comments section">

                <div class="container">

                    <h4 class="comments-count">{{ $information->comments->count() }} Komentar</h4>

                    @if ($information->comments->isEmpty())
                    <p>Belum ada komentar. Jadilah yang pertama!</p>
                    @else
                    @foreach ($information->comments as $comment)
                    <div class="comment">
                        <div class="d-flex">
                            {{-- <div class="comment-img">
                                <img src="{{ asset('default-avatar.png') }}" alt="">
                            </div> --}}
                            <div>
                                <h4>{{ $comment->user->name }}</h4>
                                <time datetime="{{ $comment->created_at }}">{{ $comment->created_at->format('d M Y')
                                    }}</time>
                                <p>{{ $comment->body }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>

            </section>

            <!-- /Blog Comments Section -->

            <!-- Comment Form Section -->
            {{-- <section id="comment-form" class="comment-form section">
                <div class="container">

                    <form action="">

                        <h4>Post Comment</h4>
                        <p>Your email address will not be published. Required fields are marked * </p>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input name="name" type="text" class="form-control" placeholder="Your Name*">
                            </div>
                            <div class="col-md-6 form-group">
                                <input name="email" type="text" class="form-control" placeholder="Your Email*">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group">
                                <input name="website" type="text" class="form-control" placeholder="Your Website">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group">
                                <textarea name="comment" class="form-control" placeholder="Your Comment*"></textarea>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Post Comment</button>
                        </div>

                    </form>

                </div>
            </section> --}}

            @if (auth()->check())
            <section id="comment-form" class="comment-form section">
                <div class="container">
                    <form action="{{ route('information.comment', $information->slug) }}" method="POST">
                        @csrf

                        <h4>Post Comment</h4>
                        <p>Masukkan komentar kamu di bawah ini.</p>

                        <div class="row">
                            <div class="col form-group">
                                <textarea name="body" class="form-control" placeholder="Your Comment*" required
                                    rows="5">{{ old('body') }}</textarea>
                            </div>
                        </div>

                        @error('body')
                        <div class="text-danger mb-2">{{ $message }}</div>
                        @enderror

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Post Comment</button>
                        </div>
                    </form>
                </div>
            </section>
            @else
            <div class="alert alert-info mt-3">
                Silakan <a href="{{ route('login') }}">login</a> untuk memberikan komentar.
            </div>
            @endif

            <!-- /Comment Form Section -->

        </div>

        <div class="col-lg-4 sidebar">

            <div class="widgets-container">

                <!-- Blog Author Widget -->
                <div class="blog-author-widget widget-item">

                    <div class="d-flex flex-column align-items-center">
                        <div class="d-flex align-items-center w-100">
                            {{-- <img src="assets/img/blog/blog-author.jpg" class="rounded-circle flex-shrink-0" alt="">
                            --}}
                            <div>
                                <h4>{{ $information->user->name }}</h4>
                                <div class="social-links">
                                    @if ($information->user->categories->isNotEmpty())
                                    @foreach ($information->user->categories as $category)
                                    <span class="badge bg-primary me-1">{{ $category->name }}</span>
                                    @endforeach
                                    @else
                                    <span class="text-muted">Belum memilih kategori</span>
                                    @endif
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
                <!--/Blog Author Widget -->

                <!-- Search Widget -->
                <!-- <div class="search-widget widget-item">

                                                <h3 class="widget-title">Search</h3>
                                                <form action="">
                                                  <input type="text">
                                                  <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                                                </form>

                                              </div> -->
                <!--/Search Widget -->

                <!-- Recent Posts Widget -->
                <div class="recent-posts-widget widget-item">

                    <h3 class="widget-title">Unggahan Terkini</h3>

                    @foreach($otherNews as $news)
                    <div class="post-item">
                        {{-- <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="" class="flex-shrink-0"> --}}
                        <div>
                            <h4><a href="{{ route('detail', $news->slug) }}">{{ $news->title }}</a></h4>
                            <time datetime="{{ $news->created_at->toDateString() }}">
                                {{ $news->created_at->format('M j, Y') }}
                            </time>
                        </div>
                    </div>
                    @endforeach
                    <!-- End recent post item-->

                </div>
                <!--/Recent Posts Widget -->

                {{--
                <!-- Tags Widget -->
                <div class="tags-widget widget-item">

                    <h3 class="widget-title">Tags</h3>
                    <ul>
                        <li><a href="#">App</a></li>
                        <li><a href="#">IT</a></li>
                        <li><a href="#">Business</a></li>
                        <li><a href="#">Mac</a></li>
                        <li><a href="#">Design</a></li>
                        <li><a href="#">Office</a></li>
                        <li><a href="#">Creative</a></li>
                        <li><a href="#">Studio</a></li>
                        <li><a href="#">Smart</a></li>
                        <li><a href="#">Tips</a></li>
                        <li><a href="#">Marketing</a></li>
                    </ul>

                </div>
                <!--/Tags Widget --> --}}

            </div>

        </div>

    </div>
</div>
@endsection
