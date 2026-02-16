@extends('theme.spacelink.layouts.orbit_main')
@section('title') About {{ get_option('site_name') }} @endsection
@section('meta_description', Str::limit(strip_tags(get_option('about')), 160))

@section('main')

<!-- Homepage Description Section -->
<section class="py-5" id="homepage-description">
    <div class="container">
        <h1 class="display-5 fw-bold mb-4">About {{ get_option('site_name') }}</h1>
        {!! get_option('about', 'Welcome to our website. Learn more about our services and company.') !!}
    </div>
</section>

@endsection
