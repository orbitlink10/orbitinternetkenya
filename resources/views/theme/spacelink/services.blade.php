@extends('theme.spacelink.layouts.orbit_main')

{{-- Dynamic Page Title & Meta --}}
@php
    $servicesMeta = \Illuminate\Support\Str::limit(
        \Illuminate\Support\Str::squish(strip_tags(get_option('services_page_meta', 'Discover our range of professional solutions designed to meet your needs.'))),
        155,
        ''
    );
@endphp
@section('title', get_option('services_page_title', 'Our Services'))
@section('meta_description', $servicesMeta)

@section('main')
@php
    $services = \App\Models\Service::all();
@endphp

<!--=== Services ===-->
<section id="services" class="section-py bg-white">
  <div class="container">
    <div class="text-center mb-5">
      <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 mb-3">
        Our Services
      </span>
      <h1 class="fw-bold mb-3">
       Explore Our Professional Solutions
      </h1>
      <p class="text-muted">
       Discover our range of professional solutions tailored to your needs.
      </p>
    </div>
    <div class="row g-4">
      @foreach($services as $service)
        <div class="col-sm-6 col-md-4 d-flex">
          <div class="card h-100 border-0 shadow-sm">
            @if(!empty($service->image_url))
              <img 
                src="{{ $service->image_url }}" 
                alt="{{ $service->name }}" 
                class="card-img-top" 
                loading="lazy" 
                style="height:180px; object-fit:cover;"
              >
            @endif
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">{{ $service->name }}</h5>
              <p class="card-text text-muted flex-grow-1">
                {!! $service->meta_description ?? '' !!}
              </p>
              <a 
                href="{{ route('service_single', ['slug' => $service->slug]) }}" 
                class="btn btn-primary mt-auto"
              >
                Learn More
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endsection
