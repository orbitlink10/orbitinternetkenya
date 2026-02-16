<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page not found | {{ get_option('site_name', config('app.name')) }}</title>
    <meta name="robots" content="noindex, nofollow">
    <style>
        :root {
            --primary: #003366;
            --text: #1f2937;
            --muted: #6b7280;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            color: var(--text);
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
        }
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            padding: 32px;
            max-width: 520px;
            text-align: center;
        }
        h1 { margin: 0 0 12px; font-size: 32px; color: var(--primary); }
        p  { margin: 0 0 20px; color: var(--muted); }
        a.button {
            display: inline-block;
            padding: 12px 18px;
            background: var(--primary);
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>404 — Page not found</h1>
        <p>We couldn’t find the page you’re looking for. Please check the URL or head back to the homepage.</p>
        <a class="button" href="{{ url('/') }}">Go to homepage</a>
    </div>
</body>
</html>
