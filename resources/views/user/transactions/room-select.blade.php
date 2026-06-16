@extends('layouts.user')
@section('title', 'Select Rooms')
@section('page-title', 'Select Your Rooms')

@section('content')

<div class="panel mb-4">
  <div class="panel-header">
    <h5><i class="fas fa-calendar-check me-2" style="color:var(--gold)"></i>Your Stay</h5>
  </div>
  <div class="panel-body">
    <div class="row g-3 text-center">
      <div class="col-4">
        <div style="font-size:.78rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:.06em">Check-In</div>
        <div style="font-weight:700;color:var(--navy);font-size:1.05rem">{{ $wishlist->check_in->format('d M Y') }}</div>
      </div>
      <div class="col-4">
        <div style="font-size:.78rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:.06em">Nights</div>
        <div style="font-weight:700;color:var(--gold-dark);font-size:1.4rem;font-family:'Playfair Display',serif">{{ $wishlist->nights }}</div>
      </div>
      <div class="col-4">
        <div style="font-size:.78rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:.06em">Check-Out</div>
        <div style="font-weight:700;color:var(--navy);font-size:1.05rem">{{ $wishlist->check_out->format('d M Y') }}</div>
      </div>
    </div>
  </div>
</div>

<form method="POST" action="{{ route('user.transactions.select-rooms') }}" id="roomSelectForm">
  @csrf

  @foreach($availability as $itemId => $data)
  <div class="panel mb-4">
    <div class="panel-header">
      <div>
        <h5 style="margin:0">{{ $data['room_type']->name }}</h5>
        <small style="color:var(--text-muted)">
          Select <strong>{{ $data['quantity'] }}</strong> room(s) •
          Rp {{ number_format($data['room_type']->price_per_night, 0, ',', '.') }}/night
        </small>
      </div>
      <span id="selected-count-{{ $data['room_type']->id }}"
            style="background:var(--navy);color:var(--gold);padding:.3rem .8rem;border-radius:50px;font-size:.82rem;font-weight:600">
        0 / {{ $data['quantity'] }} selected
      </span>
    </div>
    <div class="panel-body">

      @if(!$data['has_enough'])
        <div class="alert alert-warning">
          <i class="fas fa-exclamation-triangle me-2"></i>
          Not enough available rooms for your selected dates. Please adjust your dates or quantity.
        </div>
      @endif

      @if($data['rooms']->isEmpty())
        <p style="color:var(--text-muted);text-align:center;padding:1rem">
          No rooms available for this type on the selected dates.
        </p>
      @else
        {{-- Room Matrix Table --}}
        <div class="table-responsive">
          <table style="width:100%;border-collapse:collapse">
            <thead>
              <tr style="background:var(--off-white)">
                <th style="padding:.75rem 1rem;font-size:.78rem;font-weight:600;color:var(--navy);letter-spacing:.06em;text-transform:uppercase;width:120px">View</th>
                <th style="padding:.75rem 1rem;font-size:.78rem;font-weight:600;color:var(--navy);letter-spacing:.06em;text-transform:uppercase">Available Rooms</th>
              </tr>
            </thead>
            <tbody>
              @foreach(['city' => '🏙 City View', 'sea' => '🌊 Sea View', 'pool' => '🏊 Pool View'] as $view => $label)
                @if(isset($data['rooms'][$view]) && $data['rooms'][$view]->count())
                <tr style="border-top:1px solid #F1F5F9">
                  <td style="padding:.75rem 1rem">
                    <span style="font-size:.85rem;font-weight:500;color:var(--navy)">{{ $label }}</span>
                  </td>
                  <td style="padding:.75rem 1rem">
                    <div class="d-flex flex-wrap gap-2">
                      @foreach($data['rooms'][$view] as $room)
                        <label class="room-chip" id="chip-{{ $room->id }}"
                               for="room-{{ $data['room_type']->id }}-{{ $room->id }}">
                          <input type="checkbox"
                                 id="room-{{ $data['room_type']->id }}-{{ $room->id }}"
                                 name="selected_rooms[{{ $data['room_type']->id }}][]"
                                 value="{{ $room->id }}"
                                 style="display:none"
                                 data-type="{{ $data['room_type']->id }}"
                                 data-max="{{ $data['quantity'] }}"
                                 class="room-checkbox">
                          {{ $room->room_number }}
                        </label>
                      @endforeach
                    </div>
                  </td>
                </tr>
                @endif
              @endforeach
            </tbody>
          </table>
        </div>
      @endif

    </div>
  </div>
  @endforeach

  <div class="d-flex gap-3 justify-content-between">
    <a href="{{ route('user.transactions') }}" class="btn-gold-outline" style="padding:.65rem 1.5rem">
      <i class="fas fa-arrow-left me-2"></i>Back
    </a>
    <button type="submit" class="btn-gold" style="padding:.65rem 2rem" id="continueBtn">
      <i class="fas fa-arrow-right me-2"></i>Continue to Payment
    </button>
  </div>

</form>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.room-checkbox').forEach(cb => {
  cb.addEventListener('change', function () {
    const typeId  = this.dataset.type;
    const max     = parseInt(this.dataset.max);
    const checked = document.querySelectorAll(`.room-checkbox[data-type="${typeId}"]:checked`);

    if (checked.length > max) {
      this.checked = false;
      alert(`You can only select ${max} room(s) for this type.`);
      return;
    }

    // Toggle visual class
    const chip = document.getElementById('chip-' + this.id.replace('room-' + typeId + '-', ''));
    this.closest('label').classList.toggle('selected', this.checked);

    // Update counter
    document.getElementById('selected-count-' + typeId).textContent =
      `${checked.length} / ${max} selected`;
  });
});
</script>
@endpush
