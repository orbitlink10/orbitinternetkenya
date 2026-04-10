@extends('layouts.appbar')

@section('content')
@php
    $recentOrdersCount = $recentOrders->count();
    $recommendedCount = $recommendedProducts->count();
@endphp

<div class="content-wrapper dashboard-page customer-dashboard-page">
    <section class="content-header">
        <div class="container-fluid">
            <div class="dashboard-header">
                <div>
                    <span class="dashboard-kicker">Customer Overview</span>
                    <h1 class="dashboard-title">Dashboard</h1>
                    <p class="dashboard-subtitle">View and manage your orders, payments, wishlist items, and product picks from one workspace.</p>
                </div>
                <div class="dashboard-header-actions">
                    <a href="{{ route('product') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-store"></i> Shop Products
                    </a>
                    <a href="{{ route('account.orders') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-shopping-bag"></i> My Orders
                    </a>
                    <a href="{{ route('account.details') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-user-edit"></i> Update Profile
                    </a>
                </div>
            </div>
            <ol class="breadcrumb float-sm-right dashboard-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row dashboard-row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="dashboard-stat stat-blue">
                        <div class="stat-header">
                            <span class="stat-icon"><i class="fas fa-shopping-bag"></i></span>
                            <span class="stat-label">Orders</span>
                        </div>
                        <div class="stat-value">{{ $ordersCount }}</div>
                        <div class="stat-note">{{ $pendingOrdersCount }} pending</div>
                        <a href="{{ route('account.orders') }}" class="stat-link">View orders <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="dashboard-stat stat-rose">
                        <div class="stat-header">
                            <span class="stat-icon"><i class="fas fa-heart"></i></span>
                            <span class="stat-label">Wishlist</span>
                        </div>
                        <div class="stat-value">{{ $wishlistCount }}</div>
                        <div class="stat-note">Saved products</div>
                        <a href="{{ route('wishlist.index') }}" class="stat-link">Open wishlist <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="dashboard-stat stat-emerald">
                        <div class="stat-header">
                            <span class="stat-icon"><i class="fas fa-receipt"></i></span>
                            <span class="stat-label">Payments</span>
                        </div>
                        <div class="stat-value">{{ $paymentsCount }}</div>
                        <div class="stat-note">Payment records</div>
                        <a href="{{ route('account.payments') }}" class="stat-link">View payments <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="dashboard-stat stat-amber">
                        <div class="stat-header">
                            <span class="stat-icon"><i class="fas fa-wallet"></i></span>
                            <span class="stat-label">Balance</span>
                        </div>
                        <div class="stat-value stat-value-money">KSh {{ number_format((float) $accountBalance, 2) }}</div>
                        <div class="stat-note">Available balance</div>
                        <a href="{{ route('account.payments') }}" class="stat-link">Manage balance <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="row dashboard-row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="dashboard-metric metric-slate">
                        <div class="metric-label">Pending Orders</div>
                        <div class="metric-value">{{ $pendingOrdersCount }}</div>
                        <div class="metric-sub">Awaiting payment or fulfilment</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="dashboard-metric metric-blue">
                        <div class="metric-label">Recent Orders</div>
                        <div class="metric-value">{{ $recentOrdersCount }}</div>
                        <div class="metric-sub">Latest activity in your account</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="dashboard-metric metric-emerald">
                        <div class="metric-label">Saved Products</div>
                        <div class="metric-value">{{ $wishlistCount }}</div>
                        <div class="metric-sub">Items kept for later</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="dashboard-metric metric-amber">
                        <div class="metric-label">Catalog Picks</div>
                        <div class="metric-value">{{ $recommendedCount }}</div>
                        <div class="metric-sub">Recommended items ready to browse</div>
                    </div>
                </div>
            </div>

            <div class="row dashboard-row">
                <div class="col-lg-7 mb-4">
                    <div class="card dashboard-panel">
                        <div class="dashboard-panel-header">
                            <h4 class="dashboard-panel-title">Recent Orders</h4>
                            <span class="dashboard-panel-meta">Latest purchases</span>
                        </div>

                        @if($recentOrders->isEmpty())
                            <div class="account-empty-state">
                                <span class="account-empty-icon"><i class="fas fa-receipt"></i></span>
                                <h3>No orders yet</h3>
                                <p>Your recent purchases will appear here after checkout.</p>
                                <a href="{{ route('product') }}" class="btn btn-primary btn-sm">Browse Products</a>
                            </div>
                        @else
                            <div class="dashboard-order-list">
                                @foreach($recentOrders as $order)
                                    <article class="dashboard-order-item">
                                        <div class="dashboard-order-main">
                                            <div class="dashboard-order-id">Order #{{ $order->id }}</div>
                                            <div class="dashboard-order-date">{{ optional($order->created_at)->format('d M Y') }}</div>
                                        </div>
                                        <div class="dashboard-order-status status-{{ str_replace(' ', '-', strtolower($order->status ?? 'pending')) }}">
                                            {{ ucfirst($order->status ?? 'pending') }}
                                        </div>
                                        <div class="dashboard-order-meta">
                                            <span>KSh {{ number_format((float) ($order->total_amount ?? $order->total ?? 0), 2) }}</span>
                                            @if(($order->status ?? '') === 'pending')
                                                <a href="{{ route('pay_now', $order->id) }}" class="btn btn-primary btn-sm">Pay Now</a>
                                            @else
                                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-secondary btn-sm">View Details</a>
                                            @endif
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-5 mb-4">
                    <div class="card dashboard-panel">
                        <div class="dashboard-panel-header">
                            <h4 class="dashboard-panel-title">Quick Actions</h4>
                            <span class="dashboard-panel-meta">Shortcuts</span>
                        </div>
                        <div class="dashboard-action-list">
                            <a href="{{ route('product') }}" class="dashboard-action-link">
                                <span class="action-icon"><i class="fas fa-store"></i></span>
                                <span>
                                    <strong>Shop Products</strong>
                                    <small>Browse the current catalog and place a new order</small>
                                </span>
                            </a>
                            <a href="{{ route('account.payments') }}" class="dashboard-action-link">
                                <span class="action-icon"><i class="fas fa-wallet"></i></span>
                                <span>
                                    <strong>Review Payments</strong>
                                    <small>Check completed and pending payment records</small>
                                </span>
                            </a>
                            <a href="{{ route('account.details') }}" class="dashboard-action-link">
                                <span class="action-icon"><i class="fas fa-id-card"></i></span>
                                <span>
                                    <strong>Update Profile</strong>
                                    <small>Edit your account details and contact information</small>
                                </span>
                            </a>
                            <a href="{{ route('wishlist.index') }}" class="dashboard-action-link">
                                <span class="action-icon"><i class="fas fa-star"></i></span>
                                <span>
                                    <strong>Open Wishlist</strong>
                                    <small>Return to products you have saved for later</small>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row dashboard-row">
                <div class="col-12 mb-2">
                    <div class="card dashboard-panel">
                        <div class="dashboard-panel-header">
                            <h4 class="dashboard-panel-title">Recommended Products</h4>
                            <span class="dashboard-panel-meta">Useful items from the catalog</span>
                        </div>

                        @if($recommendedProducts->isEmpty())
                            <div class="account-empty-state account-empty-inline">
                                <span class="account-empty-icon"><i class="fas fa-box-open"></i></span>
                                <div>
                                    <h3>No products available right now</h3>
                                    <p>Add products in the catalog to surface recommendations here.</p>
                                </div>
                            </div>
                        @else
                            <div class="account-product-grid">
                                @foreach($recommendedProducts as $product)
                                    @php
                                        $photo = trim((string) $product->photo);
                                        $photoUrl = null;

                                        if ($photo !== '') {
                                            if (\Illuminate\Support\Str::startsWith($photo, ['http://', 'https://'])) {
                                                $photoUrl = $photo;
                                            } elseif (\Illuminate\Support\Str::startsWith($photo, ['/images?', 'images?'])) {
                                                $photoUrl = \Illuminate\Support\Str::startsWith($photo, '/')
                                                    ? $photo
                                                    : url('/' . ltrim($photo, '/'));
                                            } elseif (\Illuminate\Support\Str::startsWith($photo, ['/storage/', 'storage/'])) {
                                                $photoUrl = route('images', ['path' => ltrim(\Illuminate\Support\Str::after($photo, 'storage/'), '/')]);
                                            } elseif (\Illuminate\Support\Str::startsWith($photo, ['/uploads/', 'uploads/'])) {
                                                $photoUrl = route('images', ['path' => ltrim($photo, '/')]);
                                            } elseif (\Illuminate\Support\Str::startsWith($photo, ['/assets/', 'assets/', '/lucare/', 'lucare/'])) {
                                                $photoUrl = asset(ltrim($photo, '/'));
                                            } elseif (\Illuminate\Support\Str::startsWith($photo, '/')) {
                                                $photoUrl = $photo;
                                            } else {
                                                $photoUrl = route('images', ['path' => ltrim($photo, '/')]);
                                            }
                                        }
                                    @endphp
                                    <article class="account-product-card">
                                        <div class="account-product-media {{ $photoUrl ? '' : 'is-missing' }}">
                                            <div class="account-product-placeholder">
                                                <i class="fas fa-image"></i>
                                                <span>Image coming soon</span>
                                            </div>
                                            @if($photoUrl)
                                                <img
                                                    src="{{ $photoUrl }}"
                                                    alt="{{ $product->name }}"
                                                    loading="lazy"
                                                    onerror="var media=this.closest('.account-product-media'); if (media) { media.classList.add('is-missing'); } this.remove();"
                                                >
                                            @endif
                                        </div>
                                        <div class="account-product-body">
                                            <h3>{{ $product->name }}</h3>
                                            <p>KSh {{ number_format((float) $product->price, 2) }}</p>
                                            <a href="{{ route('product_details', $product->slug) }}" class="btn btn-outline-secondary btn-sm">View Product</a>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .dashboard-page {
        background: #f4f6fb;
        padding-bottom: 24px;
    }

    .dashboard-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }

    .dashboard-kicker {
        display: inline-flex;
        padding: 6px 14px;
        border-radius: 999px;
        background: #e2e8f0;
        color: #475569;
        font-size: 0.7rem;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        font-weight: 600;
    }

    .dashboard-title {
        margin: 8px 0 6px;
        font-size: 2rem;
        color: #0f172a;
        font-weight: 600;
    }

    .dashboard-subtitle {
        margin: 0;
        color: #64748b;
        font-size: 0.95rem;
    }

    .dashboard-header-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
    }

    .dashboard-header-actions .btn {
        border-radius: 999px;
        padding: 0.35rem 0.95rem;
        font-weight: 600;
    }

    .dashboard-breadcrumb {
        margin-top: 12px;
    }

    .dashboard-stat {
        background: #ffffff;
        border-radius: 18px;
        padding: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 18px 32px rgba(15, 23, 42, 0.08);
        position: relative;
        overflow: hidden;
        min-height: 170px;
    }

    .dashboard-stat::after {
        content: "";
        position: absolute;
        right: -40px;
        top: -40px;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: var(--stat-glow);
        opacity: 0.12;
    }

    .stat-header {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--stat-soft);
        color: var(--stat-accent);
        font-size: 18px;
    }

    .stat-label {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #64748b;
        font-weight: 600;
    }

    .stat-value {
        font-size: 1.9rem;
        font-weight: 600;
        color: #0f172a;
        margin: 10px 0 6px;
        line-height: 1.15;
    }

    .stat-value-money {
        font-size: 1.55rem;
    }

    .stat-note {
        color: #94a3b8;
        font-size: 0.88rem;
        margin-bottom: 10px;
    }

    .stat-link {
        font-size: 0.85rem;
        text-decoration: none;
        color: var(--stat-accent);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
    }

    .stat-blue {
        --stat-accent: #2563eb;
        --stat-soft: rgba(37, 99, 235, 0.12);
        --stat-glow: #2563eb;
    }

    .stat-emerald {
        --stat-accent: #059669;
        --stat-soft: rgba(5, 150, 105, 0.12);
        --stat-glow: #059669;
    }

    .stat-amber {
        --stat-accent: #d97706;
        --stat-soft: rgba(217, 119, 6, 0.12);
        --stat-glow: #d97706;
    }

    .stat-rose {
        --stat-accent: #e11d48;
        --stat-soft: rgba(225, 29, 72, 0.12);
        --stat-glow: #e11d48;
    }

    .dashboard-metric {
        background: #ffffff;
        border-radius: 16px;
        padding: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 14px 26px rgba(15, 23, 42, 0.06);
        position: relative;
        overflow: hidden;
        min-height: 150px;
    }

    .dashboard-metric::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        height: 4px;
        width: 100%;
        background: var(--metric-accent);
    }

    .metric-label {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #64748b;
        font-weight: 600;
    }

    .metric-value {
        font-size: 1.4rem;
        font-weight: 600;
        color: #0f172a;
        margin: 10px 0 6px;
    }

    .metric-sub {
        color: #94a3b8;
        font-size: 0.85rem;
    }

    .metric-slate {
        --metric-accent: #334155;
    }

    .metric-blue {
        --metric-accent: #3b82f6;
    }

    .metric-emerald {
        --metric-accent: #10b981;
    }

    .metric-amber {
        --metric-accent: #f59e0b;
    }

    .dashboard-panel {
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        box-shadow: 0 18px 32px rgba(15, 23, 42, 0.08);
        overflow: hidden;
        background: #ffffff;
    }

    .dashboard-panel-header {
        padding: 18px 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .dashboard-panel-title {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #0f172a;
    }

    .dashboard-panel-meta {
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .dashboard-order-list {
        padding: 18px 20px 20px;
        display: grid;
        gap: 12px;
    }

    .dashboard-order-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 16px 18px;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
    }

    .dashboard-order-main {
        min-width: 0;
        flex: 1;
    }

    .dashboard-order-id {
        font-weight: 700;
        color: #0f172a;
    }

    .dashboard-order-date {
        color: #64748b;
        font-size: 0.9rem;
        margin-top: 4px;
    }

    .dashboard-order-status {
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 0.76rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .dashboard-order-status.status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .dashboard-order-status.status-paid,
    .dashboard-order-status.status-processing {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .dashboard-order-status.status-completed,
    .dashboard-order-status.status-delivered {
        background: #dcfce7;
        color: #166534;
    }

    .dashboard-order-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #0f172a;
        font-weight: 600;
        white-space: nowrap;
    }

    .dashboard-action-list {
        display: grid;
        gap: 12px;
        padding: 18px 20px 20px;
    }

    .dashboard-action-link {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #0f172a;
        text-decoration: none;
    }

    .dashboard-action-link:hover {
        background: #eef2ff;
        border-color: #c7d2fe;
        color: #1e3a8a;
    }

    .dashboard-action-link strong,
    .dashboard-action-link small {
        display: block;
    }

    .dashboard-action-link small {
        color: #64748b;
        font-size: 0.82rem;
    }

    .action-icon {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: #e0e7ff;
        color: #1d4ed8;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .account-empty-state {
        padding: 28px 20px 30px;
        text-align: center;
    }

    .account-empty-inline {
        display: flex;
        align-items: center;
        gap: 16px;
        text-align: left;
        padding: 24px 20px 26px;
    }

    .account-empty-icon {
        width: 56px;
        height: 56px;
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #e0e7ff;
        color: #1d4ed8;
        font-size: 1.35rem;
        flex-shrink: 0;
    }

    .account-empty-state h3 {
        margin: 14px 0 8px;
        font-size: 1.15rem;
        color: #0f172a;
    }

    .account-empty-state p {
        margin: 0 0 16px;
        color: #64748b;
    }

    .account-empty-inline h3,
    .account-empty-inline p {
        margin: 0;
    }

    .account-product-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        padding: 20px;
    }

    .account-product-card {
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        background: #ffffff;
    }

    .account-product-media {
        position: relative;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        background: linear-gradient(135deg, #eff6ff 0%, #f8fafc 100%);
    }

    .account-product-media img,
    .account-product-placeholder {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
    }

    .account-product-media img {
        z-index: 1;
        display: block;
        object-fit: cover;
        background: #f8fafc;
    }

    .account-product-media.is-missing img {
        display: none;
    }

    .account-product-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 20px;
        color: #64748b;
        font-size: 1.5rem;
        text-align: center;
    }

    .account-product-placeholder span {
        font-size: 0.85rem;
        font-weight: 600;
    }

    .account-product-body {
        padding: 16px;
    }

    .account-product-body h3 {
        margin: 0 0 8px;
        font-size: 1rem;
        color: #0f172a;
        min-height: 48px;
    }

    .account-product-body p {
        margin: 0 0 12px;
        color: #1d4ed8;
        font-weight: 700;
    }

    @media (max-width: 1200px) {
        .account-product-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 991.98px) {
        .dashboard-order-item {
            flex-wrap: wrap;
        }

        .dashboard-order-meta {
            width: 100%;
            justify-content: space-between;
        }
    }

    @media (max-width: 768px) {
        .dashboard-title {
            font-size: 1.6rem;
        }

        .dashboard-header-actions {
            width: 100%;
        }

        .account-product-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .account-empty-inline {
            flex-direction: column;
            align-items: flex-start;
        }

        .dashboard-panel-header {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endsection
