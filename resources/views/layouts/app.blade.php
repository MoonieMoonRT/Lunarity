<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="The Lunarity — A luxury hotel experience redefined. Elegant rooms, world-class dining, and unparalleled hospitality.">
  <title>@yield('title', 'The Lunarity — Luxury Hotel')</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/lunarity.css') }}">
  @stack('styles')
</head>
<body>

{{-- Public Navbar --}}
<nav class="lnr-navbar">
  <a href="{{ route('home') }}" class="lnr-logo">
    <span class="moon-icon">☽</span>
    <span class="brand-name">The <span>Lunarity</span></span>
  </a>
  <ul class="lnr-nav-links">
    @auth
      @if(auth()->user()->isAdmin())
        <li><a href="{{ route('admin.dashboard') }}" class="btn-gold-outline">Admin Panel</a></li>
      @else
        <li><a href="{{ route('user.dashboard') }}" class="btn-gold-outline">Dashboard</a></li>
      @endif
      <li>
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
          @csrf
          <button type="submit" class="btn-gold">Logout</button>
        </form>
      </li>
    @else
      <li><a href="{{ route('login') }}" class="btn-gold-outline">Login</a></li>
      <li><a href="{{ route('register') }}" class="btn-gold">Register</a></li>
    @endauth
  </ul>
</nav>

{{-- Flash Messages --}}
@if(session('success'))
<div class="toast-container">
  <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
</div>
@endif

@yield('content')

{{-- Footer --}}
<footer class="lnr-footer">
  <div class="container">
    <div class="row gy-4">
      <div class="col-md-4">
        <div class="footer-brand">
          <span>☽</span> The Lunarity
        </div>
        <p style="font-size:.88rem;line-height:1.7;margin-top:.5rem">Where elegance meets comfort. Your sanctuary of luxury awaits.</p>
      </div>
      <div class="col-md-4">
        <h6 style="color:#fff;margin-bottom:.75rem;font-family:'Playfair Display',serif">Contact Us</h6>
        <p style="font-size:.88rem;margin-bottom:.4rem"><i class="fas fa-phone me-2" style="color:var(--gold)"></i> 08xx xxxx xxxx</p>
        <p style="font-size:.88rem"><i class="fas fa-envelope me-2" style="color:var(--gold)"></i> rehuelpurba2@gmail.com</p>
      </div>
      <div class="col-md-4">
        <h6 style="color:#fff;margin-bottom:.75rem;font-family:'Playfair Display',serif">Follow Us</h6>
        <div class="footer-social">
          <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" title="Facebook"><i class="fab fa-facebook"></i></a>
          <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
          <a href="#" title="TripAdvisor"><i class="fab fa-tripadvisor"></i></a>
        </div>
      </div>
    </div>
    <hr style="border-color:var(--navy-border);margin:1.5rem 0">
    <p style="text-align:center;font-size:.82rem">&copy; {{ date('Y') }} The Lunarity. All rights reserved.</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
