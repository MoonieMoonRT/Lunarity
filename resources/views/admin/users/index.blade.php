@extends('layouts.admin')
@section('title', 'User Management')
@section('page-title', 'User Management')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
  <form method="GET" class="d-flex gap-2 flex-wrap">
    <input type="text" name="search" value="{{ request('search') }}" class="form-control" style="width:220px" placeholder="Search name or email…">
    <select name="role" class="form-select" style="width:140px">
      <option value="">All Roles</option>
      <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Guests</option>
      <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admins</option>
    </select>
    <button type="submit" class="btn-navy" style="padding:.55rem 1.2rem;font-size:.875rem">
      <i class="fas fa-search me-1"></i>Filter
    </button>
    @if(request('search') || request('role'))
      <a href="{{ route('admin.users') }}" class="btn-gold-outline" style="padding:.55rem 1rem;font-size:.875rem">Clear</a>
    @endif
  </form>
  <a href="{{ route('admin.users.create') }}" class="btn-gold" style="padding:.6rem 1.25rem">
    <i class="fas fa-user-plus me-2"></i>New User
  </a>
</div>

<div class="panel">
  <div class="panel-body p-0">
    <div class="table-responsive">
      <table class="lnr-table">
        <thead>
          <tr><th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Date of Birth</th><th>Registered</th><th>Actions</th></tr>
        </thead>
        <tbody>
          @forelse($users as $u)
          <tr>
            <td style="color:var(--text-muted);font-size:.8rem">{{ $users->firstItem() + $loop->index }}</td>
            <td>
              <div style="font-weight:600;color:var(--navy)">{{ $u->name }}</div>
            </td>
            <td style="font-size:.88rem">{{ $u->email }}</td>
            <td>
              <span style="padding:.25rem .7rem;border-radius:50px;font-size:.75rem;font-weight:600;
                background:{{ $u->role === 'admin' ? 'rgba(201,168,76,.15)' : '#F1F5F9' }};
                color:{{ $u->role === 'admin' ? 'var(--gold-dark)' : 'var(--navy)' }}">
                {{ ucfirst($u->role) }}
              </span>
            </td>
            <td style="font-size:.88rem">{{ $u->date_of_birth?->format('d M Y') ?? '—' }}</td>
            <td style="font-size:.82rem;color:var(--text-muted)">{{ $u->created_at->format('d M Y') }}</td>
            <td>
              <div class="d-flex gap-2">
                <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-outline-secondary">
                  <i class="fas fa-edit"></i>
                </a>
                @if($u->id !== auth()->id())
                <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger"
                          onclick="return confirm('Delete {{ $u->name }}?')">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:2rem">No users found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($users->hasPages())
  <div class="panel-body border-top">{{ $users->links() }}</div>
  @endif
</div>

@endsection
