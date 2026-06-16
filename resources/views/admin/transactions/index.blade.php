@extends('layouts.admin')
@section('title', 'Transaction Monitoring')
@section('page-title', 'Transaction Monitoring')

@section('content')

{{-- User Selector --}}
<div class="panel mb-4">
  <div class="panel-header">
    <h5><i class="fas fa-filter me-2" style="color:var(--gold)"></i>Select Guest</h5>
  </div>
  <div class="panel-body">
    <form method="GET" class="row g-3">
      <div class="col-md-5">
        <label class="form-label">Guest Account</label>
        <select name="user_id" class="form-select" id="userSelect">
          <option value="">— Choose a guest —</option>
          @foreach($users as $u)
            <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
              {{ $u->name }} ({{ $u->email }})
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="">All Statuses</option>
          @foreach(['pending','active','completed','cancelled'] as $s)
            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn-navy w-100 justify-content-center" style="padding:.65rem">
          <i class="fas fa-search me-2"></i>Search
        </button>
      </div>
    </form>
  </div>
</div>

@if($selectedUser)
<div class="panel mb-4" style="border-left:3px solid var(--gold)">
  <div class="panel-body" style="padding:.9rem 1.5rem">
    <div class="d-flex align-items-center gap-3">
      <i class="fas fa-user-circle fa-2x" style="color:var(--gold)"></i>
      <div>
        <div style="font-weight:700;color:var(--navy)">{{ $selectedUser->name }}</div>
        <div style="font-size:.85rem;color:var(--text-muted)">{{ $selectedUser->email }}</div>
      </div>
      <div class="ms-auto">
        <span style="background:var(--off-white);border-radius:50px;padding:.3rem .9rem;font-size:.82rem;color:var(--navy)">
          {{ $bookings->total() }} booking(s)
        </span>
      </div>
    </div>
  </div>
</div>

<div class="panel">
  <div class="panel-body p-0">
    <table class="lnr-table">
      <thead>
        <tr><th>Code</th><th>Check-In</th><th>Check-Out</th><th>Rooms</th><th>Total</th><th>Payment</th><th>Status</th><th>Actions</th></tr>
      </thead>
      <tbody>
        @forelse($bookings as $b)
        <tr>
          <td><a href="{{ route('admin.transactions.show', $b->id) }}"
                 style="font-weight:700;color:var(--navy);text-decoration:none">{{ $b->booking_code }}</a></td>
          <td>{{ $b->check_in->format('d M Y') }}</td>
          <td>{{ $b->check_out->format('d M Y') }}</td>
          <td>{{ $b->details->count() }} room(s)</td>
          <td style="font-weight:600;color:var(--gold-dark)">Rp {{ number_format($b->total_amount,0,',','.') }}</td>
          <td style="font-size:.82rem;text-transform:capitalize">{{ str_replace('_',' ',$b->payment_method) }}</td>
          <td>
            <span class="badge-status badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span>
          </td>
          <td>
            <form method="POST" action="{{ route('admin.transactions.update-status', $b->id) }}" class="d-flex gap-1">
              @csrf @method('PATCH')
              <select name="status" class="form-select form-select-sm" style="width:110px">
                @foreach(['pending','active','completed','cancelled'] as $s)
                  <option value="{{ $s }}" {{ $b->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
              </select>
              <button type="submit" class="btn btn-sm btn-outline-secondary">✓</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;color:var(--text-muted);padding:2rem">No bookings found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($bookings->hasPages())
  <div class="panel-body border-top">{{ $bookings->links() }}</div>
  @endif
</div>
@else
<div class="panel text-center" style="padding:3rem">
  <i class="fas fa-search fa-3x mb-3" style="color:var(--text-muted)"></i>
  <p style="color:var(--text-muted)">Select a guest from the dropdown above to view their booking history.</p>
</div>
@endif

@endsection
