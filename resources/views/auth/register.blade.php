<!DOCTYPE html>
<html lang="en">
@php
    $rawSiteName = trim((string) get_option('site_name', 'OrbitInternet Kenya'));
    $normalizedSiteName = strtolower($rawSiteName);
    $usesLegacyBrand =
        $normalizedSiteName === '' ||
        str_contains($normalizedSiteName, 'spacelink') ||
        str_contains($normalizedSiteName, 'amazon leo') ||
        str_contains($normalizedSiteName, 'orbitlink') ||
        str_contains($normalizedSiteName, 'nara luxury');

    $siteName = $usesLegacyBrand ? 'OrbitInternet Kenya' : $rawSiteName;

    $rawSupportEmail = trim((string) get_option('contact_email', ''));
    $normalizedSupportEmail = strtolower($rawSupportEmail);
    $emailLooksLegacy =
        $normalizedSupportEmail === '' ||
        ! filter_var($rawSupportEmail, FILTER_VALIDATE_EMAIL) ||
        str_contains($normalizedSupportEmail, 'spacelink') ||
        str_contains($normalizedSupportEmail, 'starlink') ||
        str_contains($normalizedSupportEmail, 'ikokazi');

    $supportEmail = $emailLooksLegacy ? 'info@orbitinternetkenya.co.ke' : $rawSupportEmail;
    $supportPhone = trim((string) get_option('contact_phone'));
    $supportAddress = trim((string) get_option('address'));
    $favicon = trim((string) get_option('favicon'));
    if ($favicon !== '' && ! \Illuminate\Support\Str::startsWith($favicon, ['http://', 'https://', '//'])) {
        $favicon = url($favicon);
    }

    $brandInitials = 'OI';
    $nameParts = preg_split('/\s+/', preg_replace('/[^A-Za-z0-9 ]+/', ' ', $siteName)) ?: [];
    $initials = '';
    foreach ($nameParts as $part) {
        if ($part !== '') {
            $initials .= strtoupper(substr($part, 0, 1));
        }
        if (strlen($initials) >= 2) {
            break;
        }
    }
    if ($initials !== '') {
        $brandInitials = $initials;
    }
@endphp
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Register | {{ $siteName }}</title>
    @if($favicon !== '')
        <link rel="icon" href="{{ $favicon }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --auth-bg: #f4f7fb;
            --auth-panel: #ffffff;
            --auth-text: #12213f;
            --auth-muted: #657089;
            --auth-border: #d8e0ef;
            --auth-accent: #0f62fe;
            --auth-accent-deep: #0a3fb8;
            --auth-shadow: 0 24px 80px rgba(10, 25, 56, 0.16);
            --auth-radius: 28px;
        }

        * { box-sizing: border-box; }
        html, body { margin: 0; min-height: 100%; }

        body {
            font-family: "Manrope", sans-serif;
            color: var(--auth-text);
            background:
                radial-gradient(circle at top left, rgba(15, 98, 254, 0.15), transparent 32%),
                radial-gradient(circle at bottom right, rgba(13, 27, 56, 0.18), transparent 28%),
                linear-gradient(135deg, #f8fbff 0%, #edf3fb 55%, #e8eef8 100%);
        }

        a { color: var(--auth-accent); text-decoration: none; }
        a:hover { color: var(--auth-accent-deep); }

        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 18px;
        }

        .auth-shell {
            width: min(1180px, 100%);
            display: grid;
            grid-template-columns: minmax(320px, 1.05fr) minmax(320px, 0.95fr);
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.7);
            border-radius: calc(var(--auth-radius) + 8px);
            box-shadow: var(--auth-shadow);
            overflow: hidden;
            backdrop-filter: blur(12px);
        }

        .brand-panel {
            position: relative;
            padding: 56px;
            background:
                linear-gradient(160deg, rgba(13, 27, 56, 0.96) 0%, rgba(17, 43, 97, 0.96) 58%, rgba(15, 98, 254, 0.9) 100%);
            color: #f6f9ff;
        }

        .brand-panel::before,
        .brand-panel::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            pointer-events: none;
        }

        .brand-panel::before {
            width: 240px;
            height: 240px;
            right: -80px;
            top: -40px;
            background: rgba(255, 255, 255, 0.08);
        }

        .brand-panel::after {
            width: 180px;
            height: 180px;
            left: -70px;
            bottom: -60px;
            background: rgba(255, 255, 255, 0.06);
        }

        .brand-inner,
        .form-panel { position: relative; z-index: 1; }

        .brand-lockup {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 28px;
        }

        .brand-logo {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.24), rgba(255, 255, 255, 0.08));
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand-logo-fallback {
            font-family: "Space Grotesk", sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            color: #ffffff;
        }

        .brand-name {
            font-family: "Space Grotesk", sans-serif;
            font-size: 1.45rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .brand-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.14);
            font-size: 0.84rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        .brand-panel h1 {
            margin: 0 0 16px;
            font-family: "Space Grotesk", sans-serif;
            font-size: clamp(2rem, 4vw, 3.1rem);
            line-height: 1.04;
            letter-spacing: -0.03em;
        }

        .brand-panel p {
            margin: 0;
            max-width: 520px;
            font-size: 1rem;
            line-height: 1.7;
            color: rgba(246, 249, 255, 0.82);
        }

        .brand-card {
            margin-top: 34px;
            padding: 22px 24px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .brand-card-title {
            margin: 0 0 14px;
            font-size: 0.95rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.76);
        }

        .support-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: 14px;
        }

        .support-item {
            display: flex;
            gap: 14px;
            align-items: flex-start;
        }

        .support-icon {
            width: 40px;
            height: 40px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.14);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .support-label {
            display: block;
            margin-bottom: 3px;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.66);
        }

        .support-value,
        .support-value a {
            font-size: 0.98rem;
            line-height: 1.55;
            color: #ffffff;
        }

        .form-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
            background: rgba(255, 255, 255, 0.76);
        }

        .form-card {
            width: min(470px, 100%);
            padding: 38px 34px;
            border-radius: var(--auth-radius);
            background: var(--auth-panel);
            border: 1px solid rgba(216, 224, 239, 0.72);
            box-shadow: 0 16px 40px rgba(15, 30, 63, 0.09);
        }

        .form-kicker {
            margin: 0 0 10px;
            color: var(--auth-accent);
            font-size: 0.82rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .form-card h2 {
            margin: 0 0 10px;
            font-family: "Space Grotesk", sans-serif;
            font-size: 2rem;
            line-height: 1.05;
            letter-spacing: -0.03em;
        }

        .form-intro {
            margin: 0 0 28px;
            color: var(--auth-muted);
            line-height: 1.65;
        }

        .alert {
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 16px;
            border: 1px solid transparent;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .alert-danger {
            color: #8b1e3f;
            background: #fff1f4;
            border-color: #ffd3de;
        }

        .field { margin-bottom: 18px; }
        .field label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.93rem;
            font-weight: 700;
            color: var(--auth-text);
        }

        .field input {
            width: 100%;
            padding: 15px 16px;
            border-radius: 16px;
            border: 1px solid var(--auth-border);
            background: #fbfcff;
            color: var(--auth-text);
            font: inherit;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .field input:focus {
            outline: none;
            border-color: rgba(15, 98, 254, 0.55);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(15, 98, 254, 0.12);
        }

        .field-error {
            margin-top: 8px;
            color: #b42348;
            font-size: 0.88rem;
            line-height: 1.45;
        }

        .auth-button {
            width: 100%;
            border: 0;
            border-radius: 18px;
            padding: 16px 18px;
            margin-top: 8px;
            background: linear-gradient(135deg, #0f62fe 0%, #0a3fb8 100%);
            color: #ffffff;
            font-family: "Space Grotesk", sans-serif;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.01em;
            cursor: pointer;
            transition: transform 0.18s ease, box-shadow 0.18s ease, filter 0.18s ease;
            box-shadow: 0 16px 26px rgba(15, 98, 254, 0.24);
        }

        .auth-button:hover { filter: brightness(1.03); transform: translateY(-1px); }
        .auth-button:active { transform: translateY(0); }

        .auth-footer {
            margin-top: 22px;
            text-align: center;
            color: var(--auth-muted);
            font-size: 0.95rem;
        }

        .auth-footer a { font-weight: 800; }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 18px;
            color: var(--auth-muted);
            font-size: 0.92rem;
            font-weight: 700;
        }

        @media (max-width: 980px) {
            .auth-shell { grid-template-columns: 1fr; }
            .brand-panel, .form-panel { padding: 34px 26px; }
            .brand-panel h1 { font-size: 2.25rem; }
        }

        @media (max-width: 560px) {
            .auth-page { padding: 14px; }
            .brand-panel, .form-panel { padding: 22px 18px; }
            .form-card { padding: 28px 20px; border-radius: 24px; }
            .brand-name { font-size: 1.2rem; }
            .brand-panel h1 { font-size: 1.85rem; }
        }
    </style>
</head>
<body>
    <main class="auth-page">
        <div class="auth-shell">
            <section class="brand-panel">
                <div class="brand-inner">
                    <div class="brand-lockup">
                        <a href="{{ url('/') }}" class="brand-logo" aria-label="{{ $siteName }} home">
                            <span class="brand-logo-fallback">{{ $brandInitials }}</span>
                        </a>
                        <div class="brand-name">{{ $siteName }}</div>
                    </div>

                    <div class="brand-eyebrow">Create Account</div>
                    <h1>Register for customer dashboard access.</h1>
                    <p>Create your account to track orders, manage your details, and access your customer dashboard.</p>

                    <div class="brand-card">
                        <p class="brand-card-title">Support</p>
                        <ul class="support-list">
                            @if($supportEmail !== '')
                                <li class="support-item">
                                    <span class="support-icon">@</span>
                                    <div>
                                        <span class="support-label">Email</span>
                                        <div class="support-value"><a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a></div>
                                    </div>
                                </li>
                            @endif
                            @if($supportPhone !== '')
                                <li class="support-item">
                                    <span class="support-icon">P</span>
                                    <div>
                                        <span class="support-label">Phone</span>
                                        <div class="support-value"><a href="tel:{{ preg_replace('/\s+/', '', $supportPhone) }}">{{ $supportPhone }}</a></div>
                                    </div>
                                </li>
                            @endif
                            @if($supportAddress !== '')
                                <li class="support-item">
                                    <span class="support-icon">L</span>
                                    <div>
                                        <span class="support-label">Location</span>
                                        <div class="support-value">{{ $supportAddress }}</div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </section>

            <section class="form-panel">
                <div class="form-card">
                    <p class="form-kicker">Account Registration</p>
                    <h2>Create your account</h2>
                    <p class="form-intro">Fill in your details below. Your account will be created as a customer dashboard account.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">Please correct the highlighted fields and try again.</div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" novalidate>
                        @csrf

                        <div class="field">
                            <label for="name">Full Name</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" autocomplete="name" required autofocus>
                            @error('name')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="email">Email Address</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                            @error('email')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="password">Password</label>
                            <input id="password" type="password" name="password" autocomplete="new-password" required>
                            @error('password')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="password-confirm">Confirm Password</label>
                            <input id="password-confirm" type="password" name="password_confirmation" autocomplete="new-password" required>
                        </div>

                        <button type="submit" class="auth-button">Register</button>
                    </form>

                    <p class="auth-footer">
                        Already have an account?
                        <a href="{{ route('login') }}">Login</a>
                    </p>

                    <a href="{{ url('/') }}" class="back-link">Return to website</a>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
