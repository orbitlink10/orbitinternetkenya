@php
    $user = Auth::user();
@endphp

@if(!$user->is_admin())
    <li class="nav-header">Workspace</li>

    <li class="nav-item">
        <a href="{{ route('account.dashboard') }}" class="nav-link {{ request()->routeIs('account.dashboard') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-user-circle nav-icon"></i></span>
            <p>Dashboard</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('account.orders') }}" class="nav-link {{ request()->routeIs('account.orders') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-shopping-bag nav-icon"></i></span>
            <p>My Orders</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('account.payments') }}" class="nav-link {{ request()->routeIs('account.payments') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-wallet nav-icon"></i></span>
            <p>Payments</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('account.details') }}" class="nav-link {{ request()->routeIs('account.details') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-user-edit nav-icon"></i></span>
            <p>Profile</p>
        </a>
    </li>
@else
    <li class="nav-header">Overview</li>

    <li class="nav-item">
        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-tachometer-alt nav-icon"></i></span>
            <p>Dashboard</p>
        </a>
    </li>

    <li class="nav-header">Content Management</li>

    <li class="nav-item">
        <a href="{{ route('categories.index') }}" class="nav-link {{ request()->is('categories*') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-list-alt nav-icon"></i></span>
            <p>Categories</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('sub_categories.index') }}" class="nav-link {{ request()->is('sub_categories*') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-tags nav-icon"></i></span>
            <p>Sub Categories</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('products.index') }}" class="nav-link {{ request()->is('products*') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-boxes nav-icon"></i></span>
            <p>Products</p>
        </a>
    </li>

    @if(in_array(request()->getHost(), ['gamun.co.ke', 'www.gamun.co.ke']))
        <li class="nav-item">
            <a href="{{ route('admin.welding-products.index') }}" class="nav-link {{ request()->is('admin/welding-products*') ? 'active' : '' }}">
                <span class="nav-icon-wrap"><i class="fas fa-industry nav-icon"></i></span>
                <p>Welding Products</p>
            </a>
        </li>
    @endif

    <li class="nav-item">
        <a href="{{ route('orders.index') }}" class="nav-link {{ request()->is('orders*') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-shopping-cart nav-icon"></i></span>
            <p>Orders</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('invoices.index') }}" class="nav-link {{ request()->is('invoices*') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-file-invoice nav-icon"></i></span>
            <p>Invoices</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('notifications.index') }}" class="nav-link {{ request()->is('notifications*') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-bell nav-icon"></i></span>
            <p>Requests</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('designs.index') }}" class="nav-link {{ request()->is('designs*') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-drafting-compass nav-icon"></i></span>
            <p>Designs</p>
        </a>
    </li>

    <li class="nav-header">Site Administration</li>

    <li class="nav-item">
        <a href="{{ route('admin.users') }}" class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-users nav-icon"></i></span>
            <p>Users</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.pages_content') }}" class="nav-link {{ request()->routeIs('admin.pages_content') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-file-alt nav-icon"></i></span>
            <p>Homepage Content</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('sliders.index') }}" class="nav-link {{ request()->is('sliders*') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-images nav-icon"></i></span>
            <p>Sliders</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('pages') }}" class="nav-link {{ request()->is('pages*') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-edit nav-icon"></i></span>
            <p>Pages</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('service.index') }}" class="nav-link {{ request()->is('service*') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-tools nav-icon"></i></span>
            <p>Services</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('testimonials.index') }}" class="nav-link {{ request()->is('testimonials*') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-comment-dots nav-icon"></i></span>
            <p>Testimonials</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('medias.index') }}" class="nav-link {{ request()->is('medias*') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-photo-video nav-icon"></i></span>
            <p>Media</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('menus.index') }}" class="nav-link {{ request()->is('menus*') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-bars nav-icon"></i></span>
            <p>Menus</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-cogs nav-icon"></i></span>
            <p>Settings</p>
        </a>
    </li>

    <li class="nav-header">Account</li>

    <li class="nav-item">
        <a href="{{ route('account.details') }}" class="nav-link {{ request()->routeIs('account.details') ? 'active' : '' }}">
            <span class="nav-icon-wrap"><i class="fas fa-user-edit nav-icon"></i></span>
            <p>Profile</p>
        </a>
    </li>
@endif

<li class="nav-header">Session</li>

<li class="nav-item">
    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <span class="nav-icon-wrap"><i class="fas fa-sign-out-alt nav-icon"></i></span>
        <p>Logout</p>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</li>
