@extends('theme.starlinknew.layouts.app')

@section('title', $category->name.' Jobs | '.get_option('site_name', 'Amazon LEO Internet Kenya'))
@section('meta_description', 'Latest roles in '.$category->name.' from '.get_option('site_name', 'Amazon LEO Internet Kenya'))

@section('content')
<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-3 mb-4">
                    <div>
                        <div class="text-uppercase text-secondary small fw-semibold">Jobs</div>
                        <h1 class="fw-bold mb-0">{{ $category->name }}</h1>
                    </div>
                    <span class="badge bg-light text-dark px-3 py-2">
                        {{ $categoryPosts->total() }} openings
                    </span>
                </div>

                @if($categoryPosts->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach ($categoryPosts as $post)
                            <a href="{{ route('blog_single', $post->slug) }}" class="list-group-item list-group-item-action py-4">
                                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2">
                                    <div>
                                        <div class="small text-muted mb-1">{{ optional(getCounty($post->location))->name ?? 'Location TBA' }}</div>
                                        <h5 class="fw-semibold mb-1">{{ $post->title }}</h5>
                                        <p class="mb-0 text-muted">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($post->description), 140) }}
                                        </p>
                                    </div>
                                    <div class="text-md-end text-muted small">
                                        {{ optional($post->updated_at ?: $post->created_at)->format('M d, Y') }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $categoryPosts->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <h4 class="fw-bold mb-2">No jobs found for {{ $category->name }}</h4>
                        <p class="text-muted mb-0">Check back soon for new openings.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
