@extends('layouts.appbar')

@php
    $heroImage = trim((string) get_option('hero_image'));
    $logoImage = trim((string) get_option('logo'));
    $logoImageWidth = null;
    $logoImageHeight = null;
    $logoImageSize = null;

    if ($logoImage !== '') {
        $logoPath = parse_url($logoImage, PHP_URL_PATH) ?: $logoImage;
        $logoPath = ltrim($logoPath, '/');
        $candidateLogoPaths = [base_path($logoPath)];

        if (\Illuminate\Support\Str::startsWith($logoPath, 'storage/')) {
            $candidateLogoPaths[] = storage_path('app/public/' . substr($logoPath, 8));
        }

        foreach ($candidateLogoPaths as $candidateLogoPath) {
            if (!is_file($candidateLogoPath)) {
                continue;
            }

            $dimensions = @getimagesize($candidateLogoPath);
            if (!is_array($dimensions)) {
                continue;
            }

            $logoImageWidth = (int) $dimensions[0];
            $logoImageHeight = (int) $dimensions[1];
            $logoImageSize = $logoImageWidth . ' x ' . $logoImageHeight . ' px';
            break;
        }
    }
@endphp

@section('content')
<div class="content-wrapper homepage-content-page">
    <section class="content-header">
        <div class="container-fluid px-0">
            <div class="homepage-header">
                <div>
                    <span class="homepage-kicker">Content Management</span>
                    <h1>Update Homepage Content</h1>
                    <p class="homepage-subtitle">Edit the homepage hero, supporting copy, and long-form content from one structured workspace.</p>
                </div>
                <div class="homepage-header-actions">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-2"></i> Dashboard
                    </a>
                    <button type="submit" form="homepage-content-form" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i> Save Changes
                    </button>
                </div>
            </div>

        </div>
    </section>

    <section class="content">
        <div class="container-fluid px-0">
            @if (session('success'))
                <div class="alert alert-success homepage-alert">{{ session('success') }}</div>
            @endif

            <form id="homepage-content-form" action="{{ route('save_settings') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card homepage-editor-card">
                    <div class="card-header">
                        <h3 class="card-title">Homepage Content Management</h3>
                    </div>

                    <div class="card-body">
                        <div class="homepage-editor-grid">
                            <section class="editor-section editor-section-wide">
                                <div class="editor-section-head">
                                    <div>
                                        <h2>Hero Section</h2>
                                        <p>Set the main headline, supporting description, and the hero image shown at the top of the homepage.</p>
                                    </div>
                                </div>

                                <div class="editor-field">
                                    <label for="hero_header_title">Hero Header Title</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="hero_header_title"
                                        id="hero_header_title"
                                        value="{{ get_option('hero_header_title', 'OrbitInternet Kenya | High-Speed Internet Across Kenya') }}"
                                        placeholder="Hero header title"
                                        required
                                    >
                                    @if ($errors->has('hero_header_title'))
                                        <span class="text-danger">{{ $errors->first('hero_header_title') }}</span>
                                    @endif
                                </div>

                                <div class="editor-field">
                                    <label for="hero_header_description">Hero Header Description</label>
                                    <textarea class="form-control editor-textarea" name="hero_header_description" id="hero_header_description" required>{{ get_option('hero_header_description', 'Reliable internet, installation, and support services for homes and businesses across Kenya.') }}</textarea>
                                    @if ($errors->has('hero_header_description'))
                                        <span class="text-danger">{{ $errors->first('hero_header_description') }}</span>
                                    @endif
                                </div>

                                <div class="editor-media-grid">
                                    <div class="editor-field">
                                        <label for="hero_image">Hero Image (1280 x 720)</label>
                                        <input type="file" class="form-control" name="hero_image" id="hero_image" accept="image/*">
                                        <small class="field-help">Upload a landscape image for the homepage hero banner.</small>
                                    </div>

                                    <div class="editor-preview">
                                        <span class="editor-preview-label">Current Hero Image</span>
                                        @if($heroImage !== '')
                                            <img src="{{ $heroImage }}" alt="Current hero image preview" class="editor-preview-image">
                                        @else
                                            <div class="editor-preview-empty">
                                                <i class="fas fa-image"></i>
                                                <span>No hero image uploaded yet</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </section>

                            <section class="editor-section">
                                <div class="editor-section-head">
                                    <div>
                                        <h2>Brand Assets</h2>
                                        <p>Upload the primary site logo used in the header, footer, and SEO metadata.</p>
                                    </div>
                                </div>

                                <div class="editor-media-grid editor-media-grid-compact">
                                    <div class="editor-field">
                                        <label for="logo">Site Logo</label>
                                        <input type="file" class="form-control" name="logo" id="logo" accept="image/*">
                                        <small class="field-help field-help-block">Use a clear PNG, SVG, or WEBP logo. Transparent backgrounds work best.</small>
                                        <small class="field-help field-help-block">Recommended size: at least 320 x 120 px for a sharper header logo.</small>
                                        @if($logoImageSize !== null)
                                            <small class="field-help field-help-block {{ ($logoImageWidth < 320 || $logoImageHeight < 120) ? 'field-help-warning' : '' }}">
                                                Current file: {{ $logoImageSize }}@if($logoImageWidth < 320 || $logoImageHeight < 120) - this is quite small and may look soft on the site.@endif
                                            </small>
                                        @endif
                                    </div>

                                    <div class="editor-preview editor-preview-logo-panel">
                                        <span class="editor-preview-label">Current Logo</span>
                                        <div class="editor-logo-preview-stage">
                                            <img
                                                src="{{ $logoImage !== '' ? $logoImage : '' }}"
                                                alt="Current site logo preview"
                                                id="logo-preview-image"
                                                class="editor-preview-image editor-preview-image-logo{{ $logoImage === '' ? ' d-none' : '' }}"
                                            >
                                            <div class="editor-preview-empty editor-preview-empty-compact{{ $logoImage !== '' ? ' d-none' : '' }}" id="logo-preview-empty">
                                                <i class="fas fa-signature"></i>
                                                <span>No logo uploaded yet</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section class="editor-section">
                                <div class="editor-section-head">
                                    <div>
                                        <h2>Homepage Highlights</h2>
                                        <p>Control the supporting messaging blocks displayed after the hero section.</p>
                                    </div>
                                </div>

                                <div class="editor-field">
                                    <label for="why_choose_title">Why Choose Title</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="why_choose_title"
                                        id="why_choose_title"
                                        value="{{ get_option('why_choose_title', 'Why Choose OrbitInternet Kenya') }}"
                                        required
                                    >
                                    @if ($errors->has('why_choose_title'))
                                        <span class="text-danger">{{ $errors->first('why_choose_title') }}</span>
                                    @endif
                                </div>

                                <div class="editor-field">
                                    <label for="why_choose_description">Why Choose Description</label>
                                    <textarea class="form-control editor-textarea" name="why_choose_description" id="why_choose_description" required>{{ get_option('why_choose_description', 'Professional support, dependable connectivity, and solutions tailored for homes, businesses, and remote locations in Kenya.') }}</textarea>
                                    @if ($errors->has('why_choose_description'))
                                        <span class="text-danger">{{ $errors->first('why_choose_description') }}</span>
                                    @endif
                                </div>

                                <div class="editor-field">
                                    <label for="products_section_title">Products Section Title</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="products_section_title"
                                        id="products_section_title"
                                        value="{{ get_option('products_section_title', 'Hot-Selling Products') }}"
                                        required
                                    >
                                    @if ($errors->has('products_section_title'))
                                        <span class="text-danger">{{ $errors->first('products_section_title') }}</span>
                                    @endif
                                </div>
                            </section>

                            <section class="editor-section">
                                <div class="editor-section-head">
                                    <div>
                                        <h2>Publishing Notes</h2>
                                        <p>Use this screen to manage core homepage sections without editing code.</p>
                                    </div>
                                </div>

                                <ul class="editor-checklist">
                                    <li>Keep the hero title concise and keyword-focused.</li>
                                    <li>Use the homepage content editor for long-form SEO or marketing sections.</li>
                                    <li>Review image dimensions before uploading large hero banners.</li>
                                    <li>Save changes after editing each block to keep the homepage aligned.</li>
                                </ul>
                            </section>

                            <section class="editor-section editor-section-wide">
                                <div class="editor-section-head">
                                    <div>
                                        <h2>Home Page Content</h2>
                                        <p>Manage the main homepage article and supporting long-form text.</p>
                                    </div>
                                </div>
                                <textarea id="home_page_description" class="rich-editor" name="homepage_description">{{ get_option('homepage_description') }}</textarea>
                            </section>

                            <section class="editor-section editor-section-wide">
                                <div class="editor-section-head">
                                    <div>
                                        <h2>About Us</h2>
                                        <p>Update the core about section content shown across the site.</p>
                                    </div>
                                </div>
                                <textarea id="about" class="rich-editor" name="about">{{ get_option('about') }}</textarea>
                            </section>

                            <section class="editor-section editor-section-wide">
                                <div class="editor-section-head">
                                    <div>
                                        <h2>FAQ</h2>
                                        <p>Maintain the frequently asked questions content and answers.</p>
                                    </div>
                                </div>
                                <textarea id="faq" class="rich-editor" name="faq">{{ get_option('faq') }}</textarea>
                            </section>

                            <section class="editor-section editor-section-wide">
                                <div class="editor-section-head">
                                    <div>
                                        <h2>Terms</h2>
                                        <p>Edit the terms and policy copy used across the website.</p>
                                    </div>
                                </div>
                                <textarea id="terms" class="rich-editor" name="terms">{{ get_option('terms') }}</textarea>
                            </section>
                        </div>
                    </div>

                    <div class="card-footer homepage-editor-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i> Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap');

    .homepage-content-page {
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .homepage-content-page input,
    .homepage-content-page textarea,
    .homepage-content-page button,
    .homepage-content-page select,
    .homepage-content-page .btn,
    .homepage-content-page .form-control,
    .homepage-content-page .breadcrumb,
    .homepage-content-page .card-title {
        font-family: inherit;
    }

    .homepage-content-page .content-header {
        padding-bottom: 16px;
    }

    .homepage-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        flex-wrap: wrap;
    }

    .homepage-kicker {
        display: inline-flex;
        align-items: center;
        padding: 8px 14px;
        border-radius: 999px;
        background: #edf3ff;
        color: #2f6df6;
        font-size: 0.76rem;
        font-weight: 700;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        margin-bottom: 12px;
    }

    .homepage-subtitle {
        margin: 10px 0 0;
        color: #7085a2;
        max-width: 760px;
        line-height: 1.7;
        font-size: 1.05rem;
        font-weight: 400;
    }

    .homepage-header-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .homepage-header h1 {
        color: #132b54;
        font-size: 0.875rem;
        line-height: 1.4;
        font-weight: 900;
        letter-spacing: 0;
        margin: 0;
    }

    .homepage-alert {
        margin-bottom: 18px;
    }

    .homepage-editor-card .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .homepage-editor-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.35fr) minmax(280px, 0.65fr);
        gap: 22px;
    }

    .editor-section {
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
        border: 1px solid #e2eaf5;
        border-radius: 24px;
        padding: 22px;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9);
    }

    .editor-section-wide {
        grid-column: 1 / -1;
    }

    .editor-section-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
    }

    .editor-section-head h2 {
        margin: 0;
        color: #132b54;
        font-size: 1.32rem;
        font-weight: 800;
        letter-spacing: -0.03em;
    }

    .editor-section-head p {
        margin: 8px 0 0;
        color: #7085a2;
        line-height: 1.65;
    }

    .editor-field + .editor-field {
        margin-top: 18px;
    }

    .editor-field label {
        display: block;
        margin-bottom: 10px;
        color: #173257;
        font-weight: 700;
        font-size: 0.98rem;
    }

    .homepage-content-page .btn {
        font-weight: 700;
        letter-spacing: -0.01em;
    }

    .homepage-content-page .form-control {
        font-size: 1rem;
        font-weight: 400;
        color: #173257;
    }

    .homepage-content-page .breadcrumb {
        font-size: 1rem;
        font-weight: 400;
    }

    .editor-textarea {
        min-height: 120px;
        resize: vertical;
    }

    .field-help {
        display: inline-block;
        margin-top: 8px;
        color: #7f90a8;
        line-height: 1.5;
    }

    .field-help-block {
        display: block;
    }

    .field-help-warning {
        color: #b25b18;
        font-weight: 600;
    }

    .editor-media-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(260px, 0.85fr);
        gap: 18px;
        align-items: stretch;
        margin-top: 18px;
    }

    .editor-preview {
        border: 1px dashed #cdd9eb;
        border-radius: 22px;
        background: #f8fbff;
        min-height: 100%;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .editor-preview-label {
        color: #173257;
        font-weight: 600;
        font-size: 0.94rem;
    }

    .editor-logo-preview-stage {
        min-height: 240px;
        border-radius: 18px;
        background: linear-gradient(180deg, #ffffff 0%, #eef4ff 100%);
        padding: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .editor-preview-image {
        width: 100%;
        min-height: 210px;
        object-fit: cover;
        border-radius: 18px;
        box-shadow: 0 16px 28px rgba(31, 54, 102, 0.12);
    }

    .editor-preview-image-logo {
        width: min(100%, 360px);
        min-height: 0;
        max-height: 220px;
        object-fit: contain;
        background: #ffffff;
        padding: 24px;
        margin: 0 auto;
    }

    .editor-preview-empty {
        min-height: 210px;
        border-radius: 18px;
        display: grid;
        place-items: center;
        text-align: center;
        color: #8ca0bb;
        background: linear-gradient(180deg, #ffffff 0%, #eef4ff 100%);
        padding: 24px;
        gap: 10px;
    }

    .editor-preview-empty-compact {
        width: 100%;
        min-height: 220px;
    }

    .editor-media-grid-compact {
        grid-template-columns: minmax(0, 1fr) minmax(320px, 1fr);
    }

    .editor-preview-empty i {
        font-size: 2rem;
        color: #9ab0d0;
    }

    .editor-checklist {
        list-style: none;
        margin: 0;
        padding: 0;
        display: grid;
        gap: 12px;
    }

    .editor-checklist li {
        position: relative;
        padding-left: 18px;
        color: #5f7494;
        line-height: 1.7;
    }

    .editor-checklist li::before {
        content: "";
        position: absolute;
        left: 0;
        top: 11px;
        width: 8px;
        height: 8px;
        border-radius: 999px;
        background: #2f6df6;
    }

    .homepage-editor-footer {
        display: flex;
        justify-content: flex-end;
    }

    .homepage-content-page .tox-tinymce {
        border-radius: 22px !important;
        border-color: #dbe5f3 !important;
        box-shadow: 0 10px 24px rgba(31, 54, 102, 0.06);
        overflow: hidden;
    }

    .homepage-content-page .tox,
    .homepage-content-page .tox .tox-toolbar,
    .homepage-content-page .tox .tox-menubar,
    .homepage-content-page .tox .tox-statusbar,
    .homepage-content-page .tox .tox-edit-area__iframe {
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif !important;
    }

    @media (max-width: 1200px) {
        .homepage-editor-grid {
            grid-template-columns: 1fr;
        }

        .editor-media-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .homepage-header-actions {
            width: 100%;
        }

        .homepage-header-actions .btn {
            width: 100%;
            justify-content: center;
        }

        .editor-section {
            padding: 18px;
        }
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
<script>
    (function () {
        var editorIds = ['home_page_description', 'about', 'faq', 'terms'];
        var logoInput = document.getElementById('logo');
        var logoPreviewImage = document.getElementById('logo-preview-image');
        var logoPreviewEmpty = document.getElementById('logo-preview-empty');
        var activeLogoPreviewUrl = null;

        if (logoInput && logoPreviewImage && logoPreviewEmpty) {
            logoInput.addEventListener('change', function () {
                var file = this.files && this.files[0];

                if (!file || (file.type && file.type.indexOf('image/') !== 0)) {
                    return;
                }

                if (activeLogoPreviewUrl) {
                    URL.revokeObjectURL(activeLogoPreviewUrl);
                }

                activeLogoPreviewUrl = URL.createObjectURL(file);
                logoPreviewImage.src = activeLogoPreviewUrl;
                logoPreviewImage.classList.remove('d-none');
                logoPreviewEmpty.classList.add('d-none');
            });
        }

        editorIds.forEach(function (id) {
            if (!document.getElementById(id)) {
                return;
            }

            tinymce.init({
                selector: 'textarea#' + id,
                plugins: 'paste image advcode link lists media table code wordcount fullscreen',
                toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image media | code fullscreen',
                menubar: 'file edit view insert format tools table help',
                height: 420,
                content_style: "body { font-family: Roboto, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 16px; line-height: 1.7; color: #173257; } h1, h2, h3, h4, h5, h6 { font-family: Roboto, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; color: #132b54; font-weight: 700; letter-spacing: -0.02em; } p, li { margin-bottom: 0.85rem; }",
                image_title: true,
                automatic_uploads: true,
                promotion: false,
                branding: false,
                paste_webkit_styles: 'none',
                paste_remove_styles_if_webkit: true,
                paste_preprocess: function (plugin, args) {
                    var parser = new DOMParser();
                    var doc = parser.parseFromString('<div>' + args.content + '</div>', 'text/html');
                    var allowedAttributes = {
                        a: ['href', 'title', 'target', 'rel'],
                        img: ['src', 'alt', 'title', 'width', 'height'],
                        iframe: ['src', 'title', 'width', 'height', 'allow', 'allowfullscreen', 'frameborder'],
                        td: ['colspan', 'rowspan'],
                        th: ['colspan', 'rowspan']
                    };
                    var blockedTags = ['script', 'style', 'meta', 'link', 'base', 'form', 'input', 'button', 'textarea', 'select', 'option'];

                    doc.body.querySelectorAll('*').forEach(function (element) {
                        var tagName = element.tagName.toLowerCase();

                        if (blockedTags.indexOf(tagName) !== -1) {
                            element.remove();
                            return;
                        }

                        Array.from(element.attributes).forEach(function (attribute) {
                            var allowed = allowedAttributes[tagName] || [];

                            if (allowed.indexOf(attribute.name.toLowerCase()) === -1) {
                                element.removeAttribute(attribute.name);
                            }
                        });
                    });

                    args.content = doc.body.innerHTML;
                },
                file_picker_types: 'image',
                file_picker_callback: function (cb) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');
                    input.onchange = function () {
                        var file = this.files[0];
                        var reader = new FileReader();
                        reader.onload = function () {
                            var id = 'blobid' + (new Date()).getTime();
                            var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                            var base64 = reader.result.split(',')[1];
                            var blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);
                            cb(blobInfo.blobUri(), { title: file.name });
                        };
                        reader.readAsDataURL(file);
                    };
                    input.click();
                }
            });
        });
    })();
</script>
@endpush
