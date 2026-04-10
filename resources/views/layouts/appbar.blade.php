<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    @php
        $rawSiteName = trim((string) get_option('site_name', 'OrbitInternet Kenya'));
        $normalizedSiteName = strtolower($rawSiteName);
        $siteName = (
            $normalizedSiteName === '' ||
            str_contains($normalizedSiteName, 'spacelink') ||
            str_contains($normalizedSiteName, 'amazon leo') ||
            str_contains($normalizedSiteName, 'orbitlink')
        ) ? 'OrbitInternet Kenya' : $rawSiteName;

        $siteDesc = trim(strip_tags((string) get_option('contact_description')));
        if ($siteDesc === '' || strlen($siteDesc) < 80) {
            $fallback = strip_tags((string) get_option('hero_header_description'))
                ?: 'OrbitInternet Kenya supplies internet, networking, CCTV, and professional installation services nationwide.';
            $siteDesc = \Illuminate\Support\Str::limit(trim(preg_replace('/\\s+/', ' ', $fallback)), 155, '');
        }
        $pageDesc = trim($__env->yieldContent('meta_description')) ?: $siteDesc;
        $workspaceLabel = Auth::check() && Auth::user()->is_admin() ? 'Admin Workspace' : 'Customer Workspace';
    @endphp
    <title>{{ $siteName }}</title>
    <meta name="description" content="{{ $pageDesc }}">
    <meta name="robots" content="noindex,nofollow">
    @stack('meta')
    <link rel="icon" type="image/png" sizes="32x32" href="{{ get_option('favicon') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">

    <style>
        :root {
            --admin-bg: #eef4ff;
            --admin-sidebar: rgba(255, 255, 255, 0.78);
            --admin-panel: rgba(255, 255, 255, 0.82);
            --admin-card: #ffffff;
            --admin-text: #183153;
            --admin-muted: #7a8ea8;
            --admin-border: rgba(184, 199, 222, 0.62);
            --admin-accent: #2f6df6;
            --admin-accent-deep: #1748b6;
            --admin-accent-soft: #e9f0ff;
            --admin-shadow: 0 28px 60px rgba(31, 54, 102, 0.12);
            --admin-sidebar-width: 320px;
            --admin-radius: 30px;
        }

        html, body {
            min-height: 100%;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(47, 109, 246, 0.16), transparent 25%),
                radial-gradient(circle at right center, rgba(84, 125, 255, 0.12), transparent 18%),
                linear-gradient(180deg, #f6f9ff 0%, #eef4ff 100%);
            color: var(--admin-text);
        }

        .wrapper {
            min-height: 100vh;
            background: transparent;
        }

        .main-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--admin-sidebar-width);
            background: var(--admin-sidebar);
            backdrop-filter: blur(18px);
            border-right: 1px solid rgba(219, 229, 243, 0.92);
            box-shadow: 18px 0 42px rgba(31, 54, 102, 0.08);
            z-index: 1040;
            padding: 20px 16px 24px;
            overflow: hidden;
        }

        .sidebar {
            height: 100%;
            overflow-y: auto;
            padding-right: 6px;
        }

        .sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(90, 117, 163, 0.24);
            border-radius: 999px;
        }

        .sidebar-brand-card {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(245, 249, 255, 0.96));
            border: 1px solid rgba(218, 228, 243, 0.88);
            border-radius: 28px;
            padding: 22px 22px 18px;
            box-shadow: 0 16px 34px rgba(43, 68, 120, 0.1);
        }

        .sidebar-brand-card a {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .sidebar-brand-title {
            font-size: 1.95rem;
            font-weight: 700;
            line-height: 1.05;
            letter-spacing: -0.04em;
            margin-bottom: 8px;
        }

        .sidebar-brand-subtitle {
            font-size: 0.84rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--admin-muted);
            font-weight: 600;
        }

        .sidebar-brand-note {
            margin-top: 12px;
            color: #60738f;
            font-size: 0.92rem;
            line-height: 1.55;
        }

        .sidebar-menu-shell {
            padding-bottom: 28px;
        }

        .nav-sidebar {
            gap: 4px;
        }

        .nav-sidebar .nav-header {
            margin: 22px 0 8px;
            padding: 0 14px;
            color: #9aa9bf;
            font-size: 0.82rem;
            font-weight: 600;
            letter-spacing: 0.22em;
            text-transform: uppercase;
        }

        .nav-sidebar .nav-item {
            margin-bottom: 4px;
        }

        .nav-sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 10px 12px;
            border-radius: 22px;
            color: #35527e;
            transition: background 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease, color 0.18s ease;
        }

        .nav-sidebar .nav-link:hover {
            background: rgba(245, 249, 255, 0.96);
            box-shadow: inset 0 0 0 1px rgba(217, 228, 246, 0.9);
            color: #183153;
        }

        .nav-sidebar .nav-link.active {
            background: linear-gradient(180deg, #f7faff 0%, #edf3ff 100%);
            box-shadow: inset 0 0 0 1px #d8e4fb, 0 12px 24px rgba(47, 109, 246, 0.09);
            color: #1f4b9e;
        }

        .nav-sidebar .nav-link p {
            margin: 0;
            font-size: 1rem;
            font-weight: 500;
            line-height: 1.35;
        }

        .nav-sidebar .nav-link .nav-icon {
            margin: 0;
            width: auto;
            font-size: 1.1rem;
        }

        .nav-icon-wrap {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #edf2f9;
            color: #6f84a5;
            flex-shrink: 0;
            box-shadow: inset 0 0 0 1px rgba(220, 228, 239, 0.8);
        }

        .nav-sidebar .nav-link.active .nav-icon-wrap {
            background: linear-gradient(135deg, var(--admin-accent) 0%, var(--admin-accent-deep) 100%);
            color: #ffffff;
            box-shadow: 0 12px 20px rgba(47, 109, 246, 0.26);
        }

        .admin-main {
            margin-left: var(--admin-sidebar-width);
            padding: 24px;
            min-height: 100vh;
        }

        .admin-flash {
            margin-bottom: 16px;
        }

        .content-wrapper {
            margin-left: 0 !important;
            min-height: auto !important;
            background: var(--admin-panel);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(215, 225, 241, 0.92);
            border-radius: calc(var(--admin-radius) + 4px);
            box-shadow: var(--admin-shadow);
            overflow: hidden;
            padding-bottom: 26px;
        }

        .content-header {
            padding: 26px 30px 0;
        }

        .content {
            padding: 0 30px 10px;
        }

        .content-header h1,
        .content-header .h1 {
            margin: 0;
            color: #102a53;
            font-size: clamp(2rem, 3vw, 2.75rem);
            font-weight: 700;
            letter-spacing: -0.04em;
        }

        .content-header .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 10px 0 0;
            justify-content: flex-end;
        }

        .breadcrumb-item,
        .breadcrumb-item a {
            color: #6f83a2;
            font-size: 0.92rem;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--admin-accent);
        }

        .card {
            border: 1px solid rgba(223, 231, 243, 0.9);
            border-radius: 28px;
            overflow: hidden;
            background: var(--admin-card);
            box-shadow: 0 16px 34px rgba(29, 49, 91, 0.08);
        }

        .card-header {
            padding: 20px 26px;
            background: linear-gradient(135deg, #2f6df6 0%, #1748b6 100%);
            color: #ffffff;
            border-bottom: none;
        }

        .card-title {
            margin: 0;
            font-size: 1.08rem;
            font-weight: 600;
        }

        .card-body {
            padding: 26px;
        }

        .card-footer {
            padding: 0 26px 26px;
            border-top: none;
            background: transparent;
        }

        .btn {
            border-radius: 16px;
            font-weight: 600;
            padding: 0.7rem 1.15rem;
        }

        .btn-primary {
            border: none;
            background: linear-gradient(135deg, #2f6df6 0%, #1748b6 100%);
            box-shadow: 0 12px 20px rgba(47, 109, 246, 0.22);
        }

        .btn-outline-secondary {
            border-color: #d1ddf1;
            color: #35527e;
        }

        .form-control,
        .custom-file-input,
        .custom-file-label,
        .select2-container--default .select2-selection--single,
        .select2-container--default .select2-selection--multiple {
            border-radius: 18px !important;
            border-color: #d7e1f0 !important;
            min-height: 54px;
            box-shadow: none !important;
        }

        textarea.form-control {
            min-height: 140px;
        }

        .form-control:focus,
        .custom-file-input:focus ~ .custom-file-label,
        .select2-container--default.select2-container--focus .select2-selection--multiple,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: rgba(47, 109, 246, 0.58) !important;
            box-shadow: 0 0 0 4px rgba(47, 109, 246, 0.12) !important;
        }

        .alert {
            border-radius: 18px;
            border: none;
            box-shadow: 0 12px 24px rgba(31, 54, 102, 0.08);
        }

        .admin-mobile-bar {
            display: none;
        }

        .bottom-navbar {
            display: none;
        }

        .sidebar-backdrop {
            display: none;
        }

        @media (max-width: 991.98px) {
            body.sidebar-open {
                overflow: hidden;
            }

            .admin-mobile-bar {
                position: fixed;
                top: 12px;
                left: 14px;
                right: 14px;
                z-index: 1060;
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 10px 12px;
                border-radius: 22px;
                background: rgba(255, 255, 255, 0.92);
                backdrop-filter: blur(14px);
                box-shadow: 0 18px 30px rgba(29, 49, 91, 0.12);
                border: 1px solid rgba(220, 229, 243, 0.88);
            }

            .mobile-menu-toggle {
                width: 42px;
                height: 42px;
                border: none;
                border-radius: 14px;
                background: var(--admin-accent-soft);
                color: var(--admin-accent);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 1rem;
            }

            .mobile-brand {
                color: #17355f;
                text-decoration: none;
                font-weight: 700;
                font-size: 1rem;
                line-height: 1.3;
            }

            .main-sidebar {
                transform: translateX(-104%);
                transition: transform 0.22s ease;
            }

            body.sidebar-open .main-sidebar {
                transform: translateX(0);
            }

            .sidebar-backdrop {
                position: fixed;
                inset: 0;
                z-index: 1035;
                display: block;
                background: rgba(16, 28, 54, 0.34);
                backdrop-filter: blur(3px);
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.22s ease;
            }

            body.sidebar-open .sidebar-backdrop {
                opacity: 1;
                pointer-events: auto;
            }

            .admin-main {
                margin-left: 0;
                padding: 84px 14px 86px;
            }

            .content-wrapper {
                border-radius: 24px;
                min-height: auto !important;
            }

            .content-header {
                padding: 22px 20px 0;
            }

            .content {
                padding: 0 20px 10px;
            }

            .bottom-navbar {
                position: fixed;
                bottom: 12px;
                left: 14px;
                right: 14px;
                background: rgba(18, 42, 82, 0.96);
                border-radius: 22px;
                box-shadow: 0 20px 36px rgba(18, 42, 82, 0.24);
                display: flex;
                justify-content: space-around;
                padding: 10px 0;
                z-index: 1050;
            }

            .bottom-navbar a {
                color: rgba(226, 235, 255, 0.72);
                font-size: 12px;
                text-decoration: none;
                text-align: center;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 4px;
                min-width: 64px;
            }

            .bottom-navbar a.active,
            .bottom-navbar a:hover {
                color: #ffffff;
            }

            .bottom-navbar i {
                font-size: 18px;
            }
        }
    </style>
    @stack('styles')
    @yield('styles')
</head>
<body class="hold-transition layout-fixed {{ Auth::check() && Auth::user()->is_admin() ? 'admin-skin' : 'account-skin' }}">
    @if(Auth::check())
        <div class="admin-mobile-bar d-lg-none">
            <button type="button" class="mobile-menu-toggle" data-sidebar-toggle aria-label="Open menu">
                <i class="fas fa-bars"></i>
            </button>
            <a href="{{ Auth::user()->is_admin() ? route('home') : route('account.dashboard') }}" class="mobile-brand">{{ $siteName }}</a>
        </div>
    @endif

    <div class="wrapper">
        <aside class="main-sidebar elevation-4">
            <div class="sidebar">
                <div class="sidebar-brand-card">
                    <a href="{{ Auth::check() && Auth::user()->is_admin() ? route('home') : route('account.dashboard') }}">
                        <div class="sidebar-brand-title">{{ $siteName }}</div>
                        <div class="sidebar-brand-subtitle">{{ $workspaceLabel }}</div>
                        <div class="sidebar-brand-note">Manage content, orders, settings, and dashboard actions from one workspace.</div>
                    </a>
                </div>

                <nav class="mt-4 sidebar-menu-shell">
                    <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
                        @include('layouts.menu_links')
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="sidebar-backdrop d-lg-none" data-sidebar-toggle></div>

        <main class="admin-main">
            <div class="admin-flash">
                @include('flash_msg')
            </div>

            @yield('content')
        </main>

        @if(Auth::check() && Auth::user()->is_admin())
            <div class="bottom-navbar d-md-none">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.index') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                </a>
                <a href="{{ route('invoices.index') }}" class="{{ request()->routeIs('invoices.index') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice"></i>
                    <span>Invoices</span>
                </a>
                <a href="{{ route('admin.pages_content') }}" class="{{ request()->routeIs('admin.pages_content') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Homepage</span>
                </a>
                <a href="#" data-sidebar-toggle role="button" aria-label="Open menu">
                    <i class="fas fa-bars"></i>
                    <span>More</span>
                </a>
            </div>
        @elseif(Auth::check())
            <div class="bottom-navbar d-md-none">
                <a href="{{ route('account.dashboard') }}" class="{{ request()->routeIs('account.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('account.orders') }}" class="{{ request()->routeIs('account.orders') ? 'active' : '' }}">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Orders</span>
                </a>
                <a href="{{ route('account.payments') }}" class="{{ request()->routeIs('account.payments') ? 'active' : '' }}">
                    <i class="fas fa-wallet"></i>
                    <span>Payments</span>
                </a>
                <a href="#" data-sidebar-toggle role="button" aria-label="Open menu">
                    <i class="fas fa-bars"></i>
                    <span>More</span>
                </a>
            </div>
        @endif
    </div>

    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/sparklines/sparkline.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/js/pages/dashboard.js') }}"></script>

    <script>
        $(function () {
            const mobileSidebarBreakpoint = 991.98;

            const closeMobileSidebar = function () {
                $('body').removeClass('sidebar-open');
            };

            $(document).on('click', '[data-sidebar-toggle]', function (event) {
                if (window.innerWidth > mobileSidebarBreakpoint) {
                    return;
                }

                event.preventDefault();
                $('body').toggleClass('sidebar-open');
            });

            $(document).on('click', '.main-sidebar .nav-link', function () {
                if (window.innerWidth <= mobileSidebarBreakpoint) {
                    closeMobileSidebar();
                }
            });

            $(window).on('resize', function () {
                if (window.innerWidth > mobileSidebarBreakpoint) {
                    closeMobileSidebar();
                }
            });

            $('.select2').select2();
            $('.select2bs4').select2({ theme: 'bootstrap4' });

            if ($('#reservationdate').length) {
                $('#reservationdate').datetimepicker({ format: 'L' });
            }

            if ($('#reservation').length) {
                $('#reservation').daterangepicker();
            }

            if ($.fn.inputmask) {
                $('[data-mask]').inputmask();
            }
        });
    </script>

    @stack('scripts')
    @yield('scripts')
</body>
</html>
