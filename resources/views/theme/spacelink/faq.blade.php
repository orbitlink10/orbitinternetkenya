@extends('theme.spacelink.layouts.orbit_main')
@section('title') FAQs for {{ get_option('site_name') }} @endsection
@section('meta_description', Str::limit(strip_tags(get_option('faq')), 160))
@section('main')



<section class="py-5" id="homepage-description">
    <div class="container">
        <h1 class="fw-bold mb-4">Frequently Asked Questions</h1>
        {!! get_option('faq') !!}
    </div>
</section>
 @endsection
