@extends('layouts.user')
@section('title', 'Confirm Booking')
@section('page-title', 'Confirm Your Booking')

@section('content')

<div class="row g-4">
  <div class="col-lg-8">

    {{-- Order Summary --}}
    <div class="panel mb-4">
      <div class="panel-header">
        <h5><i class="fas fa-list-check me-2" style="color:var(--gold)"></i>Order Summary</h5>
      </div>
      <div class="panel-body p-0">
        <table class="lnr-table">
          <thead>
            <tr>
              <th>Room</th>
              <th>Type</th>
              <th>View</th>
              <th>Price/Night</th>
              <th>Nights</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orderLines as $line)
            <tr>
              <td><strong>{{ $line['room']->room_number }}</strong></td>
              <td>{{ $line['room_type']->name }}</td>
              <td>
                <span style="font-size:.8rem;padding:.2rem .6rem;border-radius:50px;
                  background:{{ $line['room']->view_type === 'sea' ? '#DBEAFE' : ($line['room']->view_type === 'pool' ? '#D1FAE5' : '#F1F5F9') }};
                  color:{{ $line['room']->view_type === 'sea' ? '#1D4ED8' : ($line['room']->view_type === 'pool' ? '#065F46' : '#475569') }}">
                  {{ ucfirst($line['room']->view_type) }} View
                </span>
              </td>
              <td>Rp {{ number_format($line['price_per_night'], 0, ',', '.') }}</td>
              <td>{{ $line['nights'] }}</td>
              <td style="font-weight:700;color:var(--gold-dark)">
                Rp {{ number_format($line['subtotal'], 0, ',', '.') }}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    {{-- Payment Method --}}
    <div class="panel">
      <div class="panel-header">
        <h5><i class="fas fa-credit-card me-2" style="color:var(--gold)"></i>Payment Method</h5>
      </div>
      <div class="panel-body">
        <form method="POST" action="{{ route('user.transactions.order') }}" id="orderForm">
          @csrf

          <div class="row g-3 mb-4">
            @foreach([
              ['qris',        'fas fa-qrcode',      'QRIS',        'Scan & pay with any e-wallet or mobile banking'],
              ['credit_card', 'fas fa-credit-card',  'Credit Card', 'Visa, Mastercard, or other major cards'],
              ['cash',        'fas fa-money-bill',   'Cash at Hotel','Pay upon arrival at Front Desk'],
            ] as [$value, $icon, $label, $desc])
            <div class="col-md-4">
              <label for="pay_{{ $value }}"
                     style="border:2px solid #E2E8F0;border-radius:var(--radius);padding:1.25rem;cursor:pointer;display:block;transition:all .2s;text-align:center"
                     class="payment-option">
                <input type="radio" name="payment_method" value="{{ $value }}" id="pay_{{ $value }}"
                       class="payment-radio" style="display:none" required>
                <i class="{{ $icon }}" style="font-size:1.75rem;color:var(--gold-dark);display:block;margin-bottom:.6rem"></i>
                <div style="font-weight:600;color:var(--navy);margin-bottom:.3rem">{{ $label }}</div>
                <div style="font-size:.76rem;color:var(--text-muted)">{{ $desc }}</div>
              </label>
            </div>
            @endforeach
          </div>

          <div style="background:var(--off-white);border:1px solid #EEE;border-radius:var(--radius);padding:1.25rem;margin-bottom:1.5rem">
            <div class="d-flex justify-content-between mb-1">
              <span style="color:var(--text-muted)">Check-In</span>
              <span style="font-weight:600">{{ $wishlist->check_in->format('d F Y') }}</span>
            </div>
            <div class="d-flex justify-content-between mb-1">
              <span style="color:var(--text-muted)">Check-Out</span>
              <span style="font-weight:600">{{ $wishlist->check_out->format('d F Y') }}</span>
            </div>
            <div class="d-flex justify-content-between mb-1">
              <span style="color:var(--text-muted)">Duration</span>
              <span style="font-weight:600">{{ $wishlist->nights }} night(s)</span>
            </div>
            <hr style="margin:.75rem 0;border-color:#E2E8F0">
            <div class="d-flex justify-content-between">
              <span style="font-weight:700;font-size:1rem">Total Amount</span>
              <span style="font-weight:700;font-size:1.2rem;color:var(--gold-dark);font-family:'Playfair Display',serif">
                Rp {{ number_format($total, 0, ',', '.') }}
              </span>
            </div>
          </div>

          <div class="d-flex gap-3">
            <a href="{{ route('user.transactions.room-select') }}" class="btn-gold-outline flex-grow-1 justify-content-center" style="padding:.7rem">
              <i class="fas fa-arrow-left me-2"></i>Back
            </a>
            <button type="submit" class="btn-gold flex-grow-1 justify-content-center" style="padding:.7rem" id="orderBtn" disabled>
              <i class="fas fa-check-circle me-2"></i>Confirm Order
            </button>
          </div>
        </form>
      </div>
    </div>

  </div>

  <div class="col-lg-4">
    <div class="panel" style="position:sticky;top:calc(var(--topbar-h) + 1rem)">
      <div class="panel-header"><h5><i class="fas fa-info-circle me-2" style="color:var(--gold)"></i>Booking Info</h5></div>
      <div class="panel-body" style="font-size:.88rem;color:var(--text-muted);line-height:1.8">
        <p><i class="fas fa-clock me-2" style="color:var(--gold)"></i>Check-in time: <strong style="color:var(--navy)">12:00 PM</strong></p>
        <p><i class="fas fa-clock me-2" style="color:var(--gold)"></i>Check-out time: <strong style="color:var(--navy)">12:00 PM</strong></p>
        <p><i class="fas fa-shield-alt me-2" style="color:var(--gold)"></i>Free cancellation before check-in</p>
        <p><i class="fas fa-concierge-bell me-2" style="color:var(--gold)"></i>24/7 concierge available</p>
        <hr style="margin:.75rem 0;border-color:#EEE">
        <p style="font-size:.78rem">
          By confirming, you agree to our booking terms and cancellation policy. Your booking status will initially be <strong>Pending</strong> until confirmed by our team.
        </p>
      </div>
    </div>
  </div>

</div>

@endsection

@push('scripts')
<script>
  const radios  = document.querySelectorAll('.payment-radio');
  const orderBtn = document.getElementById('orderBtn');
  const options  = document.querySelectorAll('.payment-option');

  radios.forEach(r => {
    r.addEventListener('change', () => {
      options.forEach(o => o.style.borderColor = '#E2E8F0');
      r.closest('label').style.borderColor = 'var(--gold)';
      r.closest('label').style.background = 'rgba(201,168,76,0.05)';
      orderBtn.disabled = false;
    });
  });
</script>
@endpush
