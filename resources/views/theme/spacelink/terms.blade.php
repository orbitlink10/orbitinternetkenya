
@extends('theme.spacelink.layouts.orbit_main')
@section('title') Terms For {{ get_option('site_name') }} @endsection
@section('main')

<section class="py-5" id="terms">
    <div class="container">
       <h1 class="fw-bold mb-4">Terms &amp; Conditions</h1>
       {!! get_option('terms') !!}
    </div>
</section>
 @endsection
