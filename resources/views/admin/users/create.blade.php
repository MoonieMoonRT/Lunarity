@extends('layouts.admin')
@section('title', 'Create User')
@section('page-title', 'Create User')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-7">
    <div class="panel">
      <div class="panel-header">
        <h5><i class="fas fa-user-plus me-2" style="color:var(--gold)"></i>New User Account</h5>
        <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-secondary">
          <i class="fas fa-arrow-left me-1"></i>Back
        </a>
      </div>
      <div class="panel-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="form-control"
                   max="{{ now()->subDay()->format('Y-m-d') }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select" required>
              <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Guest (User)</option>
              <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Min. 8 characters" required>
          </div>
          <div class="mb-4">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
          </div>
          <div class="d-flex gap-3">
            <a href="{{ route('admin.users') }}" class="btn-gold-outline flex-grow-1 justify-content-center" style="padding:.7rem">Cancel</a>
            <button type="submit" class="btn-gold flex-grow-1 justify-content-center" style="padding:.7rem">
              <i class="fas fa-save me-2"></i>Create User
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
