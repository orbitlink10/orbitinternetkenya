@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{ asset('assets/spacelink/style.css') }}">
  <style>
    :root {
      --starlink-primary: #003366;
      --starlink-accent: #001B44;
      --starlink-gradient: linear-gradient(90deg, #003366 0%, #001B44 100%);
    }
    .section-py { padding: 3rem 0; }
    @media (max-width: 768px) { .section-py { padding: 2rem 0; } }
    .text-gradient {
      background: var(--starlink-gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      display: inline-block;
    }
    @keyframes float {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-15px); }
      100% { transform: translateY(0px); }
    }
    .floating { animation: float 6s ease-in-out infinite; }
    .bg-holder { pointer-events: none; }
  </style>
@endpush

@push('scripts')
  @include('chat_widget')
  <script>
    (function () {
      function fixBodyScrollLock() {
        if (!document.body) return;
        var hasOpenModal = !!document.querySelector('.modal.show');
        if (document.body.classList.contains('modal-open') && !hasOpenModal) {
          document.body.classList.remove('modal-open');
          document.body.style.removeProperty('padding-right');
          document.body.style.removeProperty('overflow');
        }
      }

      document.addEventListener('DOMContentLoaded', fixBodyScrollLock);
      window.addEventListener('load', fixBodyScrollLock);
      document.addEventListener('hidden.bs.modal', function () {
        window.setTimeout(fixBodyScrollLock, 0);
      });
    })();
  </script>
@endpush

@include('theme.orbit.layouts.app')
@yield('main')
@include('theme.orbit.layouts.footer')
