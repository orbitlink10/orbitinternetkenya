@extends('layouts.appbar')

@section('content')
<div class="content-wrapper account-dashboard-page">
    <div class="account-dashboard-shell">
        <section class="account-hero">
            <div class="account-hero-copy">
                <span class="account-kicker">Customer Dashboard</span>
                <h1>Welcome back, {{ Auth::user()->name }}</h1>
                <p>Track orders, check payments, and jump straight into the next action without digging through the menu.</p>
            </div>
            <div class="account-hero-actions">
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
        </section>

        <section class="account-stats-grid">
            <a href="{{ route('account.orders') }}" class="account-stat-card account-stat-blue">
                <span class="account-stat-icon"><i class="fas fa-box"></i></span>
                <span class="account-stat-label">Total Orders</span>
                <strong class="account-stat-value">{{ $ordersCount }}</strong>
                <span class="account-stat-meta">{{ $pendingOrdersCount }} pending</span>
            </a>

            <a href="{{ route('wishlist.index') }}" class="account-stat-card account-stat-rose">
                <span class="account-stat-icon"><i class="fas fa-heart"></i></span>
                <span class="account-stat-label">Wishlist</span>
                <strong class="account-stat-value">{{ $wishlistCount }}</strong>
                <span class="account-stat-meta">Saved products</span>
            </a>

            <a href="{{ route('account.payments') }}" class="account-stat-card account-stat-amber">
                <span class="account-stat-icon"><i class="fas fa-wallet"></i></span>
                <span class="account-stat-label">Account Balance</span>
                <strong class="account-stat-value">KSh {{ number_format((float) $accountBalance, 2) }}</strong>
                <span class="account-stat-meta">{{ $paymentsCount }} payment records</span>
            </a>
        </section>

        <section class="account-panels">
            <div class="account-panel">
                <div class="account-panel-header">
                    <div>
                        <h2>Recent Orders</h2>
                        <p>Your latest purchases and payment status.</p>
                    </div>
                    <a href="{{ route('account.orders') }}">View all</a>
                </div>

                @if($recentOrders->isEmpty())
                    <div class="account-empty-state">
                        <span class="account-empty-icon"><i class="fas fa-receipt"></i></span>
                        <h3>No orders yet</h3>
                        <p>Your orders will appear here after checkout.</p>
                        <a href="{{ route('product') }}" class="btn btn-primary btn-sm">Browse Products</a>
                    </div>
                @else
                    <div class="account-order-list">
                        @foreach($recentOrders as $order)
                            <article class="account-order-card">
                                <div class="account-order-main">
                                    <div class="account-order-id">Order #{{ $order->id }}</div>
                                    <div class="account-order-date">{{ optional($order->created_at)->format('d M Y') }}</div>
                                </div>
                                <div class="account-order-status status-{{ str_replace(' ', '-', strtolower($order->status ?? 'pending')) }}">
                                    {{ ucfirst($order->status ?? 'pending') }}
                                </div>
                                <div class="account-order-meta">
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

            <div class="account-panel account-panel-soft">
                <div class="account-panel-header">
                    <div>
                        <h2>Quick Access</h2>
                        <p>Shortcuts to the pages you use most.</p>
                    </div>
                </div>

                <div class="account-shortcuts">
                    <a href="{{ route('account.payments') }}" class="account-shortcut-link">
                        <span><i class="fas fa-money-check-alt"></i></span>
                        <div>
                            <strong>Payments</strong>
                            <small>Review completed and pending payments.</small>
                        </div>
                    </a>

                    <a href="{{ route('account.details') }}" class="account-shortcut-link">
                        <span><i class="fas fa-id-card"></i></span>
                        <div>
                            <strong>Profile Details</strong>
                            <small>Update your name, email, and account details.</small>
                        </div>
                    </a>

                    <a href="{{ route('wishlist.index') }}" class="account-shortcut-link">
                        <span><i class="fas fa-star"></i></span>
                        <div>
                            <strong>Wishlist</strong>
                            <small>Open saved items and continue where you left off.</small>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <section class="account-panel">
            <div class="account-panel-header">
                <div>
                    <h2>Recommended Products</h2>
                    <p>Useful items and services picked from the catalog.</p>
                </div>
                <a href="{{ route('product') }}">Open shop</a>
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
                            $photo = (string) $product->photo;
                            $photoUrl = null;

                            if ($photo !== '') {
                                if (\Illuminate\Support\Str::startsWith($photo, ['http://', 'https://', '/'])) {
                                    $photoUrl = $photo;
                                } elseif (\Illuminate\Support\Str::startsWith($photo, 'storage/')) {
                                    $photoUrl = asset(ltrim($photo, '/'));
                                } else {
                                    $photoUrl = asset('storage/' . ltrim($photo, '/'));
                                }
                            }
                        @endphp
                        <article class="account-product-card">
                            <div class="account-product-media">
                                @if($photoUrl)
                                    <img src="{{ $photoUrl }}" alt="{{ $product->name }}">
                                @else
                                    <div class="account-product-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
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
        </section>
    </div>
</div>

<style>
    .account-dashboard-page {
        background:
            radial-gradient(circle at top right, rgba(47, 109, 246, 0.08), transparent 28%),
            linear-gradient(180deg, rgba(255, 255, 255, 0.9), rgba(247, 250, 255, 0.96));
        padding: 24px;
    }

    .account-dashboard-shell {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .account-hero {
        display: flex;
        justify-content: space-between;
        gap: 18px;
        flex-wrap: wrap;
        padding: 26px 28px;
        border-radius: 24px;
        background: linear-gradient(130deg, #123a7a 0%, #1d4ed8 56%, #2f6df6 100%);
        color: #f8fbff;
        box-shadow: 0 22px 42px rgba(23, 72, 182, 0.22);
    }

    .account-hero-copy {
        max-width: 560px;
    }

    .account-kicker {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.16);
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.16em;
        text-transform: uppercase;
    }

    .account-hero h1 {
        margin: 14px 0 10px;
        font-size: clamp(1.8rem, 3vw, 2.5rem);
        font-weight: 700;
        letter-spacing: -0.04em;
    }

    .account-hero p {
        margin: 0;
        max-width: 520px;
        color: rgba(248, 251, 255, 0.86);
    }

    .account-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: flex-start;
    }

    .account-hero-actions .btn-primary {
        background: #ffffff;
        color: #123a7a;
        box-shadow: none;
    }

    .account-hero-actions .btn-outline-secondary {
        border-color: rgba(255, 255, 255, 0.34);
        color: #ffffff;
        background: rgba(255, 255, 255, 0.08);
    }

    .account-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .account-stat-card {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 22px;
        border-radius: 22px;
        text-decoration: none;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 16px 28px rgba(15, 23, 42, 0.06);
        color: #0f172a;
        position: relative;
        overflow: hidden;
    }

    .account-stat-card::after {
        content: "";
        position: absolute;
        inset: auto -24px -28px auto;
        width: 96px;
        height: 96px;
        border-radius: 50%;
        background: var(--account-stat-glow);
        opacity: 0.12;
    }

    .account-stat-blue {
        --account-stat-accent: #2563eb;
        --account-stat-glow: #2563eb;
        --account-stat-soft: rgba(37, 99, 235, 0.12);
    }

    .account-stat-rose {
        --account-stat-accent: #e11d48;
        --account-stat-glow: #e11d48;
        --account-stat-soft: rgba(225, 29, 72, 0.12);
    }

    .account-stat-amber {
        --account-stat-accent: #d97706;
        --account-stat-glow: #d97706;
        --account-stat-soft: rgba(217, 119, 6, 0.12);
    }

    .account-stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--account-stat-soft);
        color: var(--account-stat-accent);
        font-size: 1.1rem;
    }

    .account-stat-label {
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #64748b;
    }

    .account-stat-value {
        font-size: 1.55rem;
        line-height: 1.2;
    }

    .account-stat-meta {
        color: #64748b;
        font-size: 0.9rem;
    }

    .account-panels {
        display: grid;
        grid-template-columns: minmax(0, 1.6fr) minmax(320px, 1fr);
        gap: 18px;
    }

    .account-panel {
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 22px;
        box-shadow: 0 18px 30px rgba(15, 23, 42, 0.06);
    }

    .account-panel-soft {
        background: linear-gradient(180deg, #fcfdff 0%, #f5f8ff 100%);
    }

    .account-panel-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 18px;
    }

    .account-panel-header h2 {
        margin: 0 0 6px;
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
    }

    .account-panel-header p {
        margin: 0;
        color: #64748b;
        font-size: 0.92rem;
    }

    .account-panel-header a {
        color: #2563eb;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
    }

    .account-order-list,
    .account-shortcuts {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .account-order-card,
    .account-shortcut-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 16px 18px;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
    }

    .account-shortcut-link {
        text-decoration: none;
        justify-content: flex-start;
        color: #0f172a;
    }

    .account-shortcut-link span {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #e8efff;
        color: #1d4ed8;
        flex-shrink: 0;
    }

    .account-shortcut-link strong,
    .account-shortcut-link small {
        display: block;
    }

    .account-shortcut-link small {
        color: #64748b;
        margin-top: 3px;
    }

    .account-order-main {
        min-width: 0;
        flex: 1;
    }

    .account-order-id {
        font-weight: 700;
        color: #0f172a;
    }

    .account-order-date {
        color: #64748b;
        font-size: 0.9rem;
        margin-top: 4px;
    }

    .account-order-status {
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 0.76rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .account-order-status.status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .account-order-status.status-paid,
    .account-order-status.status-processing {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .account-order-status.status-completed,
    .account-order-status.status-delivered {
        background: #dcfce7;
        color: #166534;
    }

    .account-order-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #0f172a;
        font-weight: 600;
        white-space: nowrap;
    }

    .account-empty-state {
        border-radius: 20px;
        border: 1px dashed #c7d2fe;
        background: #f8fbff;
        padding: 28px;
        text-align: center;
    }

    .account-empty-inline {
        display: flex;
        align-items: center;
        gap: 16px;
        text-align: left;
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
    }

    .account-product-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
    }

    .account-product-card {
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        background: #ffffff;
    }

    .account-product-media {
        aspect-ratio: 4 / 3;
        background: #f8fafc;
    }

    .account-product-media img,
    .account-product-placeholder {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .account-product-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 1.5rem;
    }

    .account-product-body {
        padding: 16px;
    }

    .account-product-body h3 {
        margin: 0 0 8px;
        font-size: 1rem;
        color: #0f172a;
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
        .account-dashboard-page {
            padding: 18px;
        }

        .account-stats-grid,
        .account-panels,
        .account-product-grid {
            grid-template-columns: 1fr;
        }

        .account-order-card {
            flex-wrap: wrap;
        }

        .account-order-meta {
            width: 100%;
            justify-content: space-between;
        }
    }

    @media (max-width: 576px) {
        .account-dashboard-page {
            padding: 16px;
        }

        .account-hero,
        .account-panel,
        .account-stat-card {
            padding: 18px;
        }

        .account-empty-inline {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endsection
