@extends('theme.spacelink.layouts.orbit_main')

@php
    $pageMeta = \Illuminate\Support\Str::limit(
        \Illuminate\Support\Str::squish(strip_tags($page->meta_description ?? $page->description ?? $page->title)),
        155,
        ''
    );
    $heroImage = !empty($page->photo)
        ? url('/images?path=' . $page->photo)
        : get_option('hero_image', asset('assets/img/default-placeholder.jpg'));
@endphp

@section('title', ($page->meta_title ?? $page->title) . ' | Spacelink Kenya')
@section('meta_description', $pageMeta)

@section('main')
@push('styles')
<style>
    :root {
        --sl-primary: #003366;
        --sl-accent: #ff8a1e;
        --sl-bg: #f6f8fb;
        --sl-muted: #6c7888;
    }
    .sl-chip {
        background: #fff;
        border: 1px solid rgba(0,0,0,.05);
        box-shadow: 0 6px 18px rgba(0,0,0,.06);
        border-radius: 999px;
        padding: 10px 18px;
        font-weight: 600;
        color: #1f2d3d;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        white-space: nowrap;
    }
    .sl-chip img { width: 36px; height: 36px; object-fit: cover; border-radius: 50%; }
    .sl-chip-row { overflow-x: auto; scrollbar-width: thin; }
    .sl-chip-row::-webkit-scrollbar { height: 8px; }
    .sl-chip-row::-webkit-scrollbar-thumb { background: rgba(0,0,0,.15); border-radius: 10px; }

    .sl-hero {
        background: radial-gradient(80% 120% at 10% 10%, #e9f2ff, #fdfdff 50%, #eef3ff 90%);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,.08);
    }
    .sl-hero h1 { font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; letter-spacing: -0.02em; }
    .sl-hero p.lead { color: var(--sl-muted); font-size: 1.05rem; }
    .sl-cta { border-radius: 999px; padding: 12px 22px; font-weight: 700; }

    .sl-article {
        background: #fff;
        border-radius: 28px;
        padding: clamp(1.5rem, 3vw, 3rem);
        box-shadow: 0 25px 60px rgba(0, 35, 80, 0.08);
        position: relative;
        overflow: hidden;
    }
    .sl-article:before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 8px;
        background: linear-gradient(180deg, var(--sl-accent), #ffb347);
    }
    .sl-article h2, .sl-article h3, .sl-article h4 { font-weight: 800; color: var(--sl-primary); margin-top: 2rem; }
    .sl-article p { color: #3d4754; line-height: 1.8; font-size: 1.05rem; }
    .sl-article a { color: var(--sl-accent); }
    .sl-article img { max-width: 100%; border-radius: 16px; margin: 1rem 0; }

    @media (max-width: 767px) {
        .sl-chip { padding: 8px 14px; }
        .sl-hero { border-radius: 16px; }
    }
</style>
@endpush

<section class="container py-4">
    {{-- Category/feature chips like starlinknew --}}
    <div class="sl-chip-row d-flex gap-3 pb-3">
        @foreach(($categories ?? collect())->take(8) as $cat)
            <div class="sl-chip">
                @php $thumb = $cat->photo ?? null; @endphp
                @if($thumb)
                    <img src="{{ $thumb }}" alt="{{ $cat->name }}" loading="lazy">
                @else
                    <span class="badge bg-primary bg-opacity-10 text-primary">#</span>
                @endif
                <a class="text-decoration-none text-dark" href="{{ url('category/'.$cat->slug) }}">{{ $cat->name }}</a>
            </div>
        @endforeach
    </div>

    {{-- Hero block --}}
    <div class="sl-hero p-4 p-md-5 mt-2">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <div class="d-flex align-items-center gap-2 mb-3 text-muted">
                    <i class="bi bi-calendar-event"></i>
                    <span>{{ optional($page->updated_at ?: $page->created_at)->format('M d, Y') }}</span>
                </div>
                <h1 class="mb-3">{{ $page->title }}</h1>
                @if(!empty($page->meta_description))
                    <p class="lead mb-4">{{ $page->meta_description }}</p>
                @endif
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ url('shop') }}" class="btn btn-dark sl-cta shadow-sm">Shop Now</a>
                    <a href="{{ route('contacts') }}" class="btn btn-outline-dark sl-cta">Talk to an Expert</a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ $heroImage }}" alt="{{ $page->title }}" class="img-fluid rounded-4 shadow-lg"
                     loading="lazy" onerror="this.src='{{ asset('assets/img/default-placeholder.jpg') }}'">
            </div>
        </div>
    </div>
</section>

<section class="container my-5">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <article class="sl-article">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h4 mb-0">{{ $page->title }}</h2>
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary">Back</a>
                </div>
                <div class="content fs-5">
                    {!! $page->description ?: '<p class="text-muted mb-0">Content coming soon.</p>' !!}
                </div>
            </article>
        </div>
    </div>
</section>

@if(isset($medias) && $medias->count() > 0)
    <section class="container pb-5">
        <div class="row g-4">
            @foreach($medias as $media)
                <div class="col-6 col-md-3">
                    <a href="{{ asset($media->file_path) }}" class="d-block rounded-3 overflow-hidden shadow-sm">
                        <img src="{{ asset($media->file_path) }}" alt="{{ $page->title }} media" class="img-fluid"
                             loading="lazy" style="object-fit: cover; height: 180px; width: 100%;">
                    </a>
                </div>
            @endforeach
        </div>
    </section>
@endif
@endsection
