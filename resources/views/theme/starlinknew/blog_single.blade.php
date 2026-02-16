@extends('theme.starlinknew.layouts.orbit_main')

@php
    $decodedSlug = html_entity_decode(rawurldecode((string) ($post->slug ?? '')), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $decodedSlug = preg_replace('/\x{00C2}(?=[\x{00A0}\s])/u', ' ', $decodedSlug);
    $decodedSlug = preg_replace('/[\x{00A0}\x{2007}\x{202F}]/u', ' ', $decodedSlug);
    $canonicalSlug = \Illuminate\Support\Str::slug(trim(preg_replace('/\s+/u', ' ', $decodedSlug)));
    $canonicalPostUrl = url($canonicalSlug !== '' ? $canonicalSlug : ($post->slug ?? request()->path()));
    $articleDescription = \Illuminate\Support\Str::limit(strip_tags((string) ($post->meta_description ?: $post->description ?: '')), 160, '');
    $articleImage = $post->photo ? asset('storage/' . $post->photo) : get_option('hero_image');
    if (!\Illuminate\Support\Str::startsWith((string) $articleImage, ['http://', 'https://', '//'])) {
        $articleImage = url((string) $articleImage);
    }
    $publisherName = trim((string) get_option('site_name', 'Amazon LEO Internet Kenya')) ?: 'Amazon LEO Internet Kenya';
    $authorName = $publisherName . ' Editorial Team';
    $publishedAt = $post->created_at ?: $post->updated_at;
    $updatedAt = $post->updated_at ?: $publishedAt;
    $publishedIso = $publishedAt ? $publishedAt->toAtomString() : null;
    $updatedIso = $updatedAt ? $updatedAt->toAtomString() : $publishedIso;
    $hasUpdatedDate = $post->created_at && $post->updated_at && $post->updated_at->gt($post->created_at);
    $publisherLogo = get_option('logo') ?: get_option('favicon');
    if (!empty($publisherLogo) && !\Illuminate\Support\Str::startsWith($publisherLogo, ['http://', 'https://', '//'])) {
        $publisherLogo = url($publisherLogo);
    }
@endphp

@section('title', $post->meta_title ?? 'Default Title')
@section('meta_description', $post->meta_description ?? $articleDescription)
@section('canonical', $canonicalPostUrl)

@section('og_title', $post->meta_title ?? $post->title)
@section('og_description', $post->meta_description ?? $articleDescription)
@section('og_image', $articleImage)
@section('og_url', $canonicalPostUrl)
@section('og_type', 'article')

@section('twitter_title', $post->meta_title ?? $post->title)
@section('twitter_description', $post->meta_description ?? $articleDescription)
@section('twitter_image', $articleImage)

@push('meta')
@php
    $blogBreadcrumb = [
        '@context' => 'https://schema.org',
        '@type'    => 'BreadcrumbList',
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => url('/'),
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => $post->title,
                'item' => $canonicalPostUrl,
            ],
        ],
    ];
    $newsArticleSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'NewsArticle',
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => $canonicalPostUrl,
        ],
        'headline' => \Illuminate\Support\Str::limit(strip_tags((string) ($post->meta_title ?: $post->title)), 110, ''),
        'description' => $articleDescription,
        'image' => [$articleImage],
        'datePublished' => $publishedIso,
        'dateModified' => $updatedIso,
        'author' => [
            '@type' => 'Organization',
            'name' => $authorName,
        ],
        'publisher' => array_filter([
            '@type' => 'Organization',
            'name' => $publisherName,
            'logo' => $publisherLogo ? [
                '@type' => 'ImageObject',
                'url' => $publisherLogo,
            ] : null,
        ]),
    ];
@endphp
@if($publishedIso)
<meta property="article:published_time" content="{{ $publishedIso }}" />
@endif
@if($updatedIso)
<meta property="article:modified_time" content="{{ $updatedIso }}" />
@endif
<meta name="author" content="{{ $authorName }}" />
<script type="application/ld+json">@json($blogBreadcrumb, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)</script>
<script type="application/ld+json">@json($newsArticleSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)</script>
@endpush

@section('main')

@push('styles')
<style>
    .uniform-height {
        height: 350px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .product-content-wrap {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .media-card2 {
        overflow: hidden;
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .media-card2 img {
        transition: transform 0.3s ease;
    }

    .media-card2:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }

    .media-card2:hover img {
        transform: scale(1.1);
    }
</style>
@endpush

<section id="header" class="py-5" style="background-color: #f9fafc;">
    <div class="container py-5">
        <div class="row align-items-center min-vh-75 min-vh-xl-100">
            <!-- Header Content -->
            <div class="col-md-6 text-md-start text-center mb-4 mb-md-0">
                <h1 class="display-4 fw-bold text-dark mb-3">{{ $post->title }}</h1>
                <div class="d-flex flex-wrap gap-3 text-muted small mb-3 justify-content-center justify-content-md-start">
                    <span>By {{ $authorName }}</span>
                    @if($publishedIso)
                    <time datetime="{{ $publishedIso }}">Published {{ optional($publishedAt)->format('M d, Y') }}</time>
                    @endif
                    @if($hasUpdatedDate && $updatedIso)
                    <time datetime="{{ $updatedIso }}">Updated {{ optional($updatedAt)->format('M d, Y') }}</time>
                    @endif
                </div>
                <p class="lead text-secondary">{{ $post->meta_description ?: $articleDescription }}</p>
                <div class="pt-4">
                    <a class="btn btn-lg btn-dark rounded-pill me-3 px-4 py-2 shadow" href="{{ url('shop') }}">Shop Now</a>
                    <a class="btn btn-lg btn-dark rounded-pill me-3 px-4 py-2 shadow" href="{{ route('contacts') }}">Talk to an Expert</a>
                </div>
            </div>

            <!-- Header Image -->
            <div class="col-md-6 text-center">
                <img class="img-fluid rounded shadow-lg"
                     src="{{ $post->photo ? asset('storage/' . $post->photo) : asset('assets/img/default-placeholder.jpg') }}"
                     alt="{{ $post->title }} image" style="max-width: 90%; border-radius: 20px;">
            </div>
        </div>
    </div>
</section>

@if($medias && $medias->count() > 0)
<section class="bg-light py-5" id="medias">
    <div class="container">
        <div id="mediaCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @foreach($medias->chunk(4) as $key => $mediaChunk)
                    <div class="carousel-item @if($key == 0) active @endif">
                        <div class="row justify-content-center">
                            @foreach($mediaChunk as $media)
                                <div class="col-md-3 col-sm-6 mb-4">
                                    <a href="{{ asset($media->file_path) }}" class="media-card2 position-relative" data-lg-size="1600-1200">
                                        <img src="{{ asset($media->file_path) }}" alt="Media Image" class="img-fluid rounded shadow-sm" style="object-fit: cover; height: 200px; width: 100%;">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#mediaCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mediaCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>
@endif

<section class="py-5" id="homepage-description">
    <div class="container">
        {!! $postBodyHtml ?? $post->description !!}
    </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/lightgallery/lightgallery.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        lightGallery(document.getElementById('mediaCarousel'), {
            selector: '.media-card2',
            download: false,
            mode: 'lg-slide',
            speed: 600,
        });
    });
</script>
@endpush

@endsection

