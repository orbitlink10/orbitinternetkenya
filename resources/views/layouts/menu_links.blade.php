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
    <a href="{{ route('enquiries') }}" class="nav-link {{ request()->routeIs('enquiries') ? 'active' : '' }}">
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

<li class="nav-header">Admin Panel</li>

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
