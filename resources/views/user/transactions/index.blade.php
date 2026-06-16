@extends('layouts.user')
@section('title', 'Transactions')
@section('page-title', 'Transactions')

@section('content')

@if(!$wishlist || $wishlist->items->count() === 0)
  <div class="panel text-center" style="padding:3rem">
    <i class="fas fa-heart-broken fa-3x mb-3" style="color:var(--text-muted)"></i>
    <h5 style="color:var(--navy)">Your wishlist is empty</h5>
    <p style="color:var(--text-muted);font-size:.9rem">Add rooms from the Room Facilities page to start booking.</p>
    <a href="{{ route('user.dashboard') }}" class="btn-gold mt-2" style="padding:.6rem 1.5rem">
      <i class="fas fa-bed me-2"></i>Browse Rooms
    </a>
  </div>
@else

<div class="row g-4">

  {{-- ── Wishlist Items ─────────────────────────── --}}
  <div class="col-lg-8">
    <div class="panel">
      <div class="panel-header">
        <h5><i class="fas fa-heart me-2" style="color:var(--gold)"></i>Wishlist Items</h5>
        <form method="POST" action="{{ route('user.wishlist.clear') }}">
          @csrf @method('DELETE')
          <button type="submit" class="btn btn-sm btn-outline-danger"
                  onclick="return confirm('Clear entire wishlist?')">
            <i class="fas fa-trash me-1"></i>Clear All
          </button>
        </form>
      </div>
      <div class="panel-body p-0">
        <table class="lnr-table">
          <thead>
            <tr>
              <th>Room Type</th>
              <th>Price/Night</th>
              <th>Quantity</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($wishlist->items as $item)
            <tr>
              <td>
                <div style="font-weight:600;color:var(--navy)">{{ $item->roomType->name }}</div>
                <div style="font-size:.78rem;color:var(--text-muted)">{{ $item->roomType->short_description }}</div>
              </td>
              <td style="font-weight:600;color:var(--gold-dark)">
                Rp {{ number_format($item->roomType->price_per_night, 0, ',', '.') }}
              </td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <form method="POST" action="{{ route('user.transactions.update-quantity', $item->id) }}">
                    @csrf <input type="hidden" name="action" value="decrease">
                    <button type="submit" class="btn btn-sm btn-outline-secondary" style="width:30px;height:30px;padding:0">−</button>
                  </form>
                  <span style="font-weight:700;font-size:1rem;width:24px;text-align:center">{{ $item->quantity }}</span>
                  <form method="POST" action="{{ route('user.transactions.update-quantity', $item->id) }}">
                    @csrf <input type="hidden" name="action" value="increase">
                    <button type="submit" class="btn btn-sm btn-outline-secondary" style="width:30px;height:30px;padding:0">+</button>
                  </form>
                </div>
              </td>
              <td>
                <form method="POST" action="{{ route('user.transactions.remove', $item->id) }}">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger"
                          onclick="return confirm('Remove this item?')">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    {{-- ── Suggested Rooms ─────────────────────── --}}
    <div class="panel mt-3">
      <div class="panel-header">
        <h5><i class="fas fa-lightbulb me-2" style="color:var(--gold)"></i>Add More Rooms</h5>
      </div>
      <div class="panel-body">
        <div class="row g-3">
          @foreach($roomTypes as $rt)
          <div class="col-md-4">
            <div style="border:1px solid #EEE;border-radius:var(--radius);padding:1rem;text-align:center">
              <div style="font-weight:600;font-size:.9rem;color:var(--navy);margin-bottom:.3rem">{{ $rt->name }}</div>
              <div style="font-size:.8rem;color:var(--gold-dark);margin-bottom:.75rem">
                Rp {{ number_format($rt->price_per_night, 0, ',', '.') }}/night
              </div>
              <form method="POST" action="{{ route('user.wishlist.add') }}">
                @csrf <input type="hidden" name="room_type_id" value="{{ $rt->id }}">
                <button type="submit" class="btn-gold" style="padding:.4rem 1rem;font-size:.82rem;width:100%;justify-content:center">
                  <i class="fas fa-plus me-1"></i>Add
                </button>
              </form>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  {{-- ── Date Selection & Summary ─────────────── --}}
  <div class="col-lg-4">
    <div class="panel">
      <div class="panel-header">
        <h5><i class="fas fa-calendar-alt me-2" style="color:var(--gold)"></i>Select Dates</h5>
      </div>
      <div class="panel-body">
        <form method="POST" action="{{ route('user.transactions.set-dates') }}">
          @csrf

          <div class="mb-3">
            <label class="form-label">Check-In Date</label>
            <input type="date" name="check_in" class="form-control"
                   value="{{ $wishlist->check_in?->format('Y-m-d') }}"
                   min="{{ now()->format('Y-m-d') }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Check-Out Date</label>
            <input type="date" name="check_out" class="form-control"
                   value="{{ $wishlist->check_out?->format('Y-m-d') }}"
                   min="{{ now()->addDay()->format('Y-m-d') }}" required>
          </div>

          @if($wishlist->check_in && $wishlist->check_out)
          <div style="background:var(--off-white);border-radius:var(--radius);padding:1rem;margin-bottom:1rem;border:1px solid #EEE">
            <div class="d-flex justify-content-between mb-1">
              <span style="font-size:.85rem;color:var(--text-muted)">Duration</span>
              <span style="font-size:.85rem;font-weight:600">{{ $wishlist->nights }} night(s)</span>
            </div>
            <div class="d-flex justify-content-between mb-1">
              <span style="font-size:.85rem;color:var(--text-muted)">Total Rooms</span>
              <span style="font-size:.85rem;font-weight:600">{{ $wishlist->total_rooms }}</span>
            </div>
            <hr style="margin:.6rem 0;border-color:#E2E8F0">
            <div class="d-flex justify-content-between">
              <span style="font-size:.88rem;font-weight:600">Estimated Total</span>
              <span style="color:var(--gold-dark);font-weight:700">
                Rp {{ number_format($wishlist->estimated_total, 0, ',', '.') }}
              </span>
            </div>
          </div>
          @endif

          <button type="submit" class="btn-navy w-100 justify-content-center" style="padding:.7rem">
            <i class="fas fa-search me-2"></i>Check Availability
          </button>
        </form>

        <div style="font-size:.78rem;color:var(--text-muted);margin-top:.75rem;line-height:1.6">
          <i class="fas fa-info-circle me-1"></i>
          Check-in and check-out time: 12:00 PM. Same-day checkout/check-in is allowed.
        </div>
      </div>
    </div>
  </div>

</div>
@endif

@endsection

@push('scripts')
<script>
  // Sync date pickers: check-out min = check-in + 1 day
  const checkIn  = document.querySelector('input[name="check_in"]');
  const checkOut = document.querySelector('input[name="check_out"]');
  if (checkIn && checkOut) {
    checkIn.addEventListener('change', () => {
      if (checkIn.value) {
        const min = new Date(checkIn.value);
        min.setDate(min.getDate() + 1);
        checkOut.min = min.toISOString().split('T')[0];
        if (checkOut.value && checkOut.value <= checkIn.value) {
          checkOut.value = min.toISOString().split('T')[0];
        }
      }
    });
  }
</script>
@endpush
