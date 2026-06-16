<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register — The Lunarity</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/lunarity.css') }}">
</head>
<body>
<div class="auth-page" style="padding:2rem 1rem">
  <div class="auth-card" style="max-width:520px">
    <div class="auth-logo">
      <div class="moon">☽</div>
      <h1>The Lunarity</h1>
      <p style="color:var(--text-muted);font-size:.88rem;margin-top:.25rem">Create your guest account</p>
    </div>

    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <div class="input-group">
          <span class="input-group-text" style="background:var(--off-white);border-color:#E2E8F0">
            <i class="fas fa-user" style="color:var(--gold)"></i>
          </span>
          <input id="name" type="text" name="name" value="{{ old('name') }}"
                 class="form-control @error('name') is-invalid @enderror"
                 placeholder="Your full name" required autofocus>
        </div>
      </div>

      <div class="mb-3">
        <label for="date_of_birth" class="form-label">Date of Birth</label>
        <div class="input-group">
          <span class="input-group-text" style="background:var(--off-white);border-color:#E2E8F0">
            <i class="fas fa-birthday-cake" style="color:var(--gold)"></i>
          </span>
          <input id="date_of_birth" type="date" name="date_of_birth"
                 value="{{ old('date_of_birth') }}"
                 class="form-control @error('date_of_birth') is-invalid @enderror"
                 max="{{ now()->subDay()->format('Y-m-d') }}" required>
        </div>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <div class="input-group">
          <span class="input-group-text" style="background:var(--off-white);border-color:#E2E8F0">
            <i class="fas fa-envelope" style="color:var(--gold)"></i>
          </span>
          <input id="reg-email" type="email" name="email" value="{{ old('email') }}"
                 class="form-control @error('email') is-invalid @enderror"
                 placeholder="your@email.com" required>
        </div>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
          <span class="input-group-text" style="background:var(--off-white);border-color:#E2E8F0">
            <i class="fas fa-lock" style="color:var(--gold)"></i>
          </span>
          <input id="reg-password" type="password" name="password"
                 class="form-control @error('password') is-invalid @enderror"
                 placeholder="Min. 8 characters" required>
        </div>
      </div>

      <div class="mb-4">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <div class="input-group">
          <span class="input-group-text" style="background:var(--off-white);border-color:#E2E8F0">
            <i class="fas fa-lock" style="color:var(--gold)"></i>
          </span>
          <input id="password_confirmation" type="password" name="password_confirmation"
                 class="form-control" placeholder="Re-enter password" required>
        </div>
      </div>

      <button type="submit" class="btn-gold w-100 justify-content-center" style="padding:.75rem">
        <i class="fas fa-user-plus me-2"></i>Create Account
      </button>
    </form>

    <hr style="margin:1.5rem 0;border-color:#E2E8F0">

    <p style="text-align:center;font-size:.88rem;color:var(--text-muted)">
      Already have an account?
      <a href="{{ route('login') }}" style="color:var(--gold-dark);font-weight:600;text-decoration:none">Sign in</a>
    </p>
    <p style="text-align:center;margin-top:.5rem">
      <a href="{{ route('home') }}" style="color:var(--text-muted);font-size:.82rem;text-decoration:none">
        <i class="fas fa-arrow-left me-1"></i>Back to Homepage
      </a>
    </p>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
