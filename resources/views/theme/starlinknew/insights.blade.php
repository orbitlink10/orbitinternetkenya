@extends('theme.starlinknew.layouts.orbit_main')

@php
  $pageTitle = 'Starlink Kenya Insights | Guides, Pricing and Installation Tips';
  $pageDescription = 'Explore Starlink Kenya guides on pricing, kits, installation, roaming, and connectivity tips for homes and businesses.';
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageDescription)
@section('og_title', $pageTitle)
@section('og_description', $pageDescription)
@section('og_url', url('insights'))
@section('twitter_title', $pageTitle)
@section('twitter_description', $pageDescription)
@section('canonical', url('insights'))

@section('main')
<section class="section-py bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 mb-3">Knowledge Hub</span>
      <h1 class="fw-bold mb-3">Starlink Kenya Insights</h1>
      <p class="text-muted mx-auto" style="max-width:760px;">
        Practical guides on Starlink setup, kit pricing, subscriptions, and performance best practices in Kenya.
      </p>
    </div>

    @if($posts->count())
      <div class="row g-4">
        @foreach($posts as $post)
          @php
            $postSlug = \Illuminate\Support\Str::slug(rawurldecode($post->slug ?? ''));
            $postUrl = url($postSlug !== '' ? $postSlug : ($post->slug ?? ''));
          @endphp
          <div class="col-md-6 col-lg-4 d-flex">
            <article class="card h-100 border-0 shadow-sm">
              <div class="card-body d-flex flex-column">
                <h2 class="h5 fw-semibold mb-3">{{ $post->title }}</h2>
                <p class="text-muted flex-grow-1">
                  {{ \Illuminate\Support\Str::limit(strip_tags($post->meta_description ?? ''), 140) }}
                </p>
                <a href="{{ $postUrl }}"
                   class="btn btn-primary mt-2"
                   aria-label="Read {{ $post->title }}"
                   title="Read {{ $post->title }}">
                  Read {{ \Illuminate\Support\Str::limit($post->title, 34) }}
                </a>
              </div>
            </article>
          </div>
        @endforeach
      </div>

      <div class="mt-4">
        {{ $posts->links() }}
      </div>
    @else
      <div class="alert alert-light border text-center mb-0">
        No insights published yet.
      </div>
    @endif
  </div>
</section>
@endsection
