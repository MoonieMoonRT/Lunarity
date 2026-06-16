<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — The Lunarity</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/lunarity.css') }}">
</head>
<body>
<div class="auth-page">
  <div class="auth-card">
    <div class="auth-logo">
      <div class="moon">☽</div>
      <h1>The Lunarity</h1>
      <p style="color:var(--text-muted);font-size:.88rem;margin-top:.25rem">Sign in to your account</p>
    </div>

    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <div class="input-group">
          <span class="input-group-text" style="background:var(--off-white);border-color:#E2E8F0">
            <i class="fas fa-envelope" style="color:var(--gold)"></i>
          </span>
          <input id="email" type="email" name="email" value="{{ old('email') }}"
                 class="form-control" placeholder="your@email.com" required autofocus>
        </div>
      </div>

      <div class="mb-4">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
          <span class="input-group-text" style="background:var(--off-white);border-color:#E2E8F0">
            <i class="fas fa-lock" style="color:var(--gold)"></i>
          </span>
          <input id="password" type="password" name="password"
                 class="form-control" placeholder="Enter password" required>
        </div>
      </div>

      <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="remember" id="remember">
          <label class="form-check-label" for="remember" style="font-size:.88rem">Remember me</label>
        </div>
      </div>

      <button type="submit" class="btn-gold w-100 justify-content-center" style="padding:.75rem">
        <i class="fas fa-sign-in-alt me-2"></i>Sign In
      </button>
    </form>

    <hr style="margin:1.5rem 0;border-color:#E2E8F0">

    <p style="text-align:center;font-size:.88rem;color:var(--text-muted)">
      Don't have an account?
      <a href="{{ route('register') }}" style="color:var(--gold-dark);font-weight:600;text-decoration:none">Register here</a>
    </p>

    <p style="text-align:center;margin-top:.75rem">
      <a href="{{ route('home') }}" style="color:var(--text-muted);font-size:.82rem;text-decoration:none">
        <i class="fas fa-arrow-left me-1"></i>Back to Homepage
      </a>
    </p>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
