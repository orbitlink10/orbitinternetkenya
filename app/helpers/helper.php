<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

function normalizeFilePath($path){
    return str_replace(['/', "\\"], DIRECTORY_SEPARATOR, $path);
}

function app_current_base_url(): string
{
    try {
        $request = app()->bound('request') ? app('request') : null;
    } catch (\Throwable $e) {
        $request = null;
    }

    if ($request) {
        return rtrim($request->getSchemeAndHttpHost(), '/');
    }

    return rtrim(url('/'), '/');
}

function app_internal_hosts(): array
{
    $hosts = [];

    $candidates = [
        parse_url((string) config('app.url'), PHP_URL_HOST),
        parse_url((string) url('/'), PHP_URL_HOST),
        'spacelinkkenya.co.ke',
        'www.spacelinkkenya.co.ke',
        'spacelinkkenya.co',
        'www.spacelinkkenya.co',
        'starlinkkenyainstallers.co.ke',
        'www.starlinkkenyainstallers.co.ke',
        'starliteinternetkenya.co.ke',
        'www.starliteinternetkenya.co.ke',
        'starlinkkenya.co.ke',
        'www.starlinkkenya.co.ke',
    ];

    foreach ($candidates as $candidate) {
        if (!is_string($candidate)) {
            continue;
        }

        $candidate = strtolower(trim($candidate));

        if ($candidate === '') {
            continue;
        }

        $hosts[$candidate] = true;
    }

    return array_keys($hosts);
}

function menu_link_url($url): string
{
    $url = is_string($url) ? trim($url) : '';

    if ($url === '') {
        return url('/');
    }

    if (!preg_match('#^https?://#i', $url)) {
        return url($url);
    }

    $parts = parse_url($url);
    $host = strtolower((string) ($parts['host'] ?? ''));

    if ($host !== '' && in_array($host, app_internal_hosts(), true)) {
        $path = $parts['path'] ?? '/';
        $path = $path === '' ? '/' : $path;

        $normalized = app_current_base_url() . $path;

        if (isset($parts['query']) && $parts['query'] !== '') {
            $normalized .= '?' . $parts['query'];
        }

        if (isset($parts['fragment']) && $parts['fragment'] !== '') {
            $normalized .= '#' . $parts['fragment'];
        }

        return $normalized;
    }

    return $url;
}

function normalizeUploadedImagePath($path){
    if (!is_string($path)) {
        return null;
    }

    $path = trim($path);

    if ($path === '') {
        return null;
    }

    if (preg_match('#^https?://#i', $path)) {
        $parsedPath = parse_url($path, PHP_URL_PATH);
        $path = $parsedPath ?: $path;
    }

    $path = rawurldecode($path);
    $path = str_replace('\\', '/', $path);
    $path = ltrim($path, '/');

    if (str_starts_with($path, 'storage/')) {
        $path = substr($path, strlen('storage/'));
    }

    $segments = [];

    foreach (explode('/', $path) as $segment) {
        if ($segment === '' || $segment === '.' || $segment === '..') {
            continue;
        }

        $segments[] = $segment;
    }

    if ($segments === []) {
        return null;
    }

    return implode('/', $segments);
}

function get_uploaded_image($path){
    $relativePath = normalizeUploadedImagePath($path);

    if(!$relativePath){
        abort(404);
    }

    $path = normalizeFilePath(storage_path('app/public/' . $relativePath));

    if(!File::exists($path) || !File::isFile($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
}

function uploaded_image_url($path, $default = null){
    $relativePath = normalizeUploadedImagePath($path);

    if ($relativePath) {
        return route('images', ['path' => $relativePath]);
    }

    if (!is_string($default)) {
        return null;
    }

    $default = trim($default);

    if ($default === '') {
        return null;
    }

    if (preg_match('#^https?://#i', $default)) {
        return $default;
    }

    return asset(ltrim($default, '/'));
}

    function get_option($option_key = '', $default = null){
      $get = \App\Models\Option::where('option_key', $option_key)->first();
      if($get && $get->option_value !== null && $get->option_value !== '') {
        return $get->option_value;
      }

      return func_num_args() > 1 ? $default : null;
    }



function upload_photo($photo){
    $fileNameWithExt = $photo->getClientOriginalName();
    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
    $extension = $photo->getClientOriginalExtension();
    $filenameToStore = $fileName . '-' . time() . '.' . $extension;
    $photo->storeAs('uploads/images/', $filenameToStore, 'public');
    $photoPath = 'uploads/images/' . $filenameToStore;
    return $photoPath;
}
