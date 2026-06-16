@extends('layouts.user')
@section('title', 'Booking ' . $booking->booking_code)
@section('page-title', 'Booking Details')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 style="font-family:'Playfair Display',serif;color:var(--navy)">
    {{ $booking->booking_code }}
  </h4>
  <a href="{{ route('user.bookings') }}" class="btn-gold-outline" style="padding:.5rem 1.1rem">
    <i class="fas fa-arrow-left me-1"></i>Back to Bookings
  </a>
</div>

<div class="row g-4">
  <div class="col-lg-8">
    <div class="panel mb-4">
      <div class="panel-header">
        <h5><i class="fas fa-bed me-2" style="color:var(--gold)"></i>Room Details</h5>
        <span class="badge-status badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
      </div>
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
  </div>
  <div class="col-lg-4">
    <div class="panel">
      <div class="panel-header"><h5>Summary</h5></div>
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
          <span style="color:var(--text-muted)">Payment</span>
          <strong>{{ ucwords(str_replace('_',' ',$booking->payment_method)) }}</strong>
        </div>
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
