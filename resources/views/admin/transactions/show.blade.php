@extends('layouts.admin')
@section('title', 'Booking ' . $booking->booking_code)
@section('page-title', 'Booking Details')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h4 style="font-family:'Playfair Display',serif;color:var(--navy);margin:0">{{ $booking->booking_code }}</h4>
    <small style="color:var(--text-muted)">Created {{ $booking->created_at->format('d M Y H:i') }}</small>
  </div>
  <div class="d-flex gap-2">
    <span class="badge-status badge-{{ $booking->status }}" style="font-size:.85rem;padding:.4rem 1rem">{{ ucfirst($booking->status) }}</span>
    <a href="{{ route('admin.transactions') }}" class="btn btn-sm btn-outline-secondary">
      <i class="fas fa-arrow-left me-1"></i>Back
    </a>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-8">
    <div class="panel mb-4">
      <div class="panel-header"><h5><i class="fas fa-bed me-2" style="color:var(--gold)"></i>Room Details</h5></div>
      <div class="panel-body p-0">
        <table class="lnr-table">
          <thead>
            <tr><th>Room #</th><th>Type</th><th>View</th><th>Price/Night</th><th>Nights</th><th>Subtotal</th></tr>
          </thead>
          <tbody>
            @foreach($booking->details as $d)
            <tr>
              <td><strong>{{ $d->room->room_number }}</strong></td>
              <td>{{ $d->roomType->name }}</td>
              <td>{{ ucfirst($d->room->view_type) }} View</td>
              <td>Rp {{ number_format($d->price_per_night,0,',','.') }}</td>
              <td>{{ $d->nights }}</td>
              <td style="font-weight:700;color:var(--gold-dark)">Rp {{ number_format($d->subtotal,0,',','.') }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    {{-- Update Status --}}
    <div class="panel">
      <div class="panel-header"><h5><i class="fas fa-edit me-2" style="color:var(--gold)"></i>Update Status</h5></div>
      <div class="panel-body">
        <form method="POST" action="{{ route('admin.transactions.update-status', $booking->id) }}" class="d-flex gap-3">
          @csrf @method('PATCH')
          <select name="status" class="form-select" style="max-width:200px">
            @foreach(['pending','active','completed','cancelled'] as $s)
              <option value="{{ $s }}" {{ $booking->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
          </select>
          <button type="submit" class="btn-gold" style="padding:.6rem 1.5rem">
            <i class="fas fa-save me-1"></i>Update
          </button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="panel mb-3">
      <div class="panel-header"><h5>Guest Info</h5></div>
      <div class="panel-body" style="font-size:.9rem">
        <p><strong>{{ $booking->user->name }}</strong></p>
        <p style="color:var(--text-muted)">{{ $booking->user->email }}</p>
        @if($booking->created_by_admin)
          <span style="background:rgba(201,168,76,.12);color:var(--gold-dark);padding:.25rem .6rem;border-radius:50px;font-size:.78rem;font-weight:600">
            Admin Reservation by {{ $booking->admin?->name ?? 'Admin' }}
          </span>
        @endif
      </div>
    </div>
    <div class="panel">
      <div class="panel-header"><h5>Payment Summary</h5></div>
      <div class="panel-body" style="font-size:.9rem">
        <div class="d-flex justify-content-between mb-2">
          <span style="color:var(--text-muted)">Check-In</span>
          <strong>{{ $booking->check_in->format('d M Y') }}</strong>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span style="color:var(--text-muted)">Check-Out</span>
          <strong>{{ $booking->check_out->format('d M Y') }}</strong>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span style="color:var(--text-muted)">Method</span>
          <strong>{{ ucwords(str_replace('_',' ',$booking->payment_method)) }}</strong>
        </div>
        @if($booking->notes)
        <div class="mb-2">
          <span style="color:var(--text-muted)">Notes</span>
          <p style="margin-top:.25rem;font-size:.85rem">{{ $booking->notes }}</p>
        </div>
        @endif
        <hr style="border-color:#EEE">
        <div class="d-flex justify-content-between">
          <strong>Total</strong>
          <strong style="color:var(--gold-dark);font-size:1.1rem">Rp {{ number_format($booking->total_amount,0,',','.') }}</strong>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
