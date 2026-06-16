@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- KPI Cards --}}
<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="stat-card">
      <div class="stat-icon gold"><i class="fas fa-users"></i></div>
      <div class="stat-value">{{ $totalUsers }}</div>
      <div class="stat-label">Registered Guests</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card">
      <div class="stat-icon navy"><i class="fas fa-calendar-check"></i></div>
      <div class="stat-value">{{ $totalBookings }}</div>
      <div class="stat-label">Total Bookings</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card">
      <div class="stat-icon green"><i class="fas fa-money-bill-wave"></i></div>
      <div class="stat-value" style="font-size:1.3rem">{{ 'Rp '.number_format($totalRevenue/1000000, 1).'M' }}</div>
      <div class="stat-label">Total Revenue</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card">
      <div class="stat-icon red"><i class="fas fa-bed"></i></div>
      <div class="stat-value">{{ $occupancyRate }}%</div>
      <div class="stat-label">Occupancy Today</div>
    </div>
  </div>
</div>

{{-- Status Summary --}}
<div class="row g-3 mb-4">
  @foreach([
    ['pending',   $pendingCount,   'fas fa-clock',       '#FEF3C7','#92400E'],
    ['active',    $activeCount,    'fas fa-check-circle','#D1FAE5','#065F46'],
    ['completed', $completedCount, 'fas fa-flag-checkered','#DBEAFE','#1E40AF'],
    ['cancelled', $cancelledCount, 'fas fa-times-circle','#FEE2E2','#991B1B'],
  ] as [$status, $count, $icon, $bg, $color])
  <div class="col-6 col-lg-3">
    <div class="stat-card" style="border-left:3px solid {{ $color }}">
      <div class="d-flex align-items-center gap-2 mb-1">
        <i class="{{ $icon }}" style="color:{{ $color }}"></i>
        <span style="font-size:.8rem;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:{{ $color }}">{{ ucfirst($status) }}</span>
      </div>
      <div class="stat-value">{{ $count }}</div>
    </div>
  </div>
  @endforeach
</div>

{{-- Occupancy Bar --}}
<div class="panel mb-4">
  <div class="panel-header">
    <h5><i class="fas fa-chart-bar me-2" style="color:var(--gold)"></i>Today's Occupancy</h5>
    <span style="font-size:.85rem;color:var(--text-muted)">{{ $bookedToday }} / {{ $totalRooms }} rooms</span>
  </div>
  <div class="panel-body">
    <div style="background:#F1F5F9;border-radius:50px;height:12px;overflow:hidden">
      <div style="background:linear-gradient(90deg,var(--gold),var(--gold-dark));height:100%;width:{{ $occupancyRate }}%;border-radius:50px;transition:width .5s ease">
      </div>
    </div>
    <div class="d-flex justify-content-between mt-1">
      <span style="font-size:.78rem;color:var(--text-muted)">0%</span>
      <span style="font-size:.78rem;color:var(--gold-dark);font-weight:600">{{ $occupancyRate }}% Occupied</span>
      <span style="font-size:.78rem;color:var(--text-muted)">100%</span>
    </div>
  </div>
</div>

{{-- Recent Bookings --}}
<div class="panel">
  <div class="panel-header">
    <h5><i class="fas fa-clock me-2" style="color:var(--gold)"></i>Recent Bookings</h5>
    <a href="{{ route('admin.transactions') }}" style="font-size:.85rem;color:var(--gold);text-decoration:none">
      View all <i class="fas fa-arrow-right ms-1"></i>
    </a>
  </div>
  <div class="panel-body p-0">
    <div class="table-responsive">
      <table class="lnr-table">
        <thead>
          <tr>
            <th>Code</th><th>Guest</th><th>Check-In</th><th>Check-Out</th>
            <th>Rooms</th><th>Total</th><th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($recentBookings as $b)
          <tr>
            <td><a href="{{ route('admin.transactions.show', $b->id) }}"
                   style="font-weight:700;color:var(--navy);text-decoration:none">{{ $b->booking_code }}</a></td>
            <td>{{ $b->user->name }}</td>
            <td>{{ $b->check_in->format('d M Y') }}</td>
            <td>{{ $b->check_out->format('d M Y') }}</td>
            <td>{{ $b->details->count() }}</td>
            <td style="font-weight:600;color:var(--gold-dark)">Rp {{ number_format($b->total_amount,0,',','.') }}</td>
            <td><span class="badge-status badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
          </tr>
          @empty
          <tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:2rem">No bookings yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
