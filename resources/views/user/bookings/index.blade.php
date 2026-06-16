@extends('layouts.user')
@section('title', 'My Bookings')
@section('page-title', 'My Bookings')

@section('content')

@if($bookings->isEmpty())
<div class="panel text-center" style="padding:3rem">
  <i class="fas fa-calendar-times fa-3x mb-3" style="color:var(--text-muted)"></i>
  <h5 style="color:var(--navy)">No bookings yet</h5>
  <p style="color:var(--text-muted);font-size:.9rem">Start by adding rooms to your wishlist and completing a booking.</p>
  <a href="{{ route('user.dashboard') }}" class="btn-gold mt-2" style="padding:.6rem 1.5rem">
    <i class="fas fa-bed me-2"></i>Browse Rooms
  </a>
</div>
@else

<div class="panel">
  <div class="panel-header">
    <h5><i class="fas fa-calendar-check me-2" style="color:var(--gold)"></i>Booking History</h5>
    <span style="font-size:.85rem;color:var(--text-muted)">{{ $bookings->total() }} booking(s)</span>
  </div>
  <div class="panel-body p-0">
    <div class="table-responsive">
      <table class="lnr-table">
        <thead>
          <tr>
            <th>Booking Code</th>
            <th>Check-In</th>
            <th>Check-Out</th>
            <th>Rooms</th>
            <th>Total</th>
            <th>Payment</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($bookings as $booking)
          <tr>
            <td>
              <a href="{{ route('user.bookings.show', $booking->id) }}"
                 style="font-weight:700;color:var(--navy);text-decoration:none;font-family:'Playfair Display',serif">
                {{ $booking->booking_code }}
              </a>
              <div style="font-size:.75rem;color:var(--text-muted)">{{ $booking->created_at->format('d M Y') }}</div>
            </td>
            <td>{{ $booking->check_in->format('d M Y') }}</td>
            <td>{{ $booking->check_out->format('d M Y') }}</td>
            <td>
              @foreach($booking->details as $d)
                <span style="font-size:.8rem;background:#F1F5F9;padding:.15rem .5rem;border-radius:4px;display:inline-block;margin:.1rem">
                  {{ $d->room->room_number }}
                </span>
              @endforeach
            </td>
            <td style="font-weight:700;color:var(--gold-dark)">
              Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
            </td>
            <td style="font-size:.82rem;text-transform:capitalize">
              {{ str_replace('_', ' ', $booking->payment_method) }}
            </td>
            <td>
              <span class="badge-status badge-{{ $booking->status }}">
                {{ ucfirst($booking->status) }}
              </span>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @if($bookings->hasPages())
  <div class="panel-body border-top">
    {{ $bookings->links() }}
  </div>
  @endif
</div>

@endif
@endsection
