<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'My Account') — The Lunarity</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/lunarity.css') }}">
  @stack('styles')
</head>
<body>

<div class="app-wrapper">

  {{-- ── Sidebar ────────────────────────────────── --}}
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <a href="{{ route('home') }}" class="lnr-logo">
        <span class="moon-icon" style="font-size:1.5rem">☽</span>
        <span class="brand-name" style="font-size:1.1rem">The <span>Lunarity</span></span>
      </a>
    </div>

    <nav class="sidebar-nav">
      <p class="nav-section-label">Guest Menu</p>

      <a href="{{ route('user.dashboard') }}"
         class="sidebar-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
        <i class="fas fa-bed"></i> Room Facilities
      </a>

      <a href="{{ route('user.transactions') }}"
         class="sidebar-link {{ request()->routeIs('user.transactions*') ? 'active' : '' }}">
        <i class="fas fa-receipt"></i> Transactions
      </a>

      <a href="{{ route('user.bookings') }}"
         class="sidebar-link {{ request()->routeIs('user.bookings*') ? 'active' : '' }}">
        <i class="fas fa-calendar-check"></i> My Bookings
      </a>

      <p class="nav-section-label" style="margin-top:1rem">Hotel Info</p>

      <a href="{{ route('user.services') }}"
         class="sidebar-link {{ request()->routeIs('user.services') ? 'active' : '' }}">
        <i class="fas fa-phone-alt"></i> Service Numbers
      </a>

      <p class="nav-section-label" style="margin-top:1rem">Account</p>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="sidebar-link w-100 border-0 bg-transparent text-start"
                style="color:var(--text-light)">
          <i class="fas fa-sign-out-alt"></i> Logout
        </button>
      </form>
    </nav>
  </aside>

  {{-- ── Topbar ─────────────────────────────────── --}}
  <header class="topbar">
    <div class="d-flex align-items-center gap-3">
      <button class="btn btn-sm d-md-none" id="sidebarToggle" style="color:var(--navy)">
        <i class="fas fa-bars fa-lg"></i>
      </button>
      <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
    </div>

    <div class="topbar-actions">
      {{-- Wishlist Icon --}}
      @php
        $wCount = \App\Models\Wishlist::where('user_id', auth()->id())
                    ->where('status','open')
                    ->withCount('items')->first()?->items_count ?? 0;
      @endphp
      <a href="{{ route('user.transactions') }}" class="wishlist-badge" title="View Wishlist">
        <i class="fas fa-heart"></i>
        @if($wCount > 0)
          <span class="badge-count">{{ $wCount }}</span>
        @endif
      </a>

      {{-- User Avatar --}}
      <div class="dropdown">
        <button class="btn btn-sm dropdown-toggle d-flex align-items-center gap-2"
                style="background:var(--off-white);border:1px solid #ddd;border-radius:50px;padding:.4rem 1rem"
                data-bs-toggle="dropdown">
          <i class="fas fa-user-circle" style="color:var(--navy)"></i>
          <span style="font-size:.85rem;color:var(--navy)">{{ auth()->user()->name }}</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><span class="dropdown-item-text text-muted" style="font-size:.8rem">{{ auth()->user()->email }}</span></li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item text-danger">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
              </button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </header>

  {{-- ── Main Content ───────────────────────────── --}}
  <main class="main-content">
    <div class="content-area">

      {{-- Toast Notifications --}}
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
          <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
          <i class="fas fa-exclamation-circle me-2"></i>
          @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @yield('content')
    </div>
  </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('sidebarToggle')?.addEventListener('click', () => {
    document.getElementById('sidebar').classList.toggle('open');
  });
</script>
@stack('scripts')
</body>
</html>
