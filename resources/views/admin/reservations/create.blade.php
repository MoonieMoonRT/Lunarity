@extends('layouts.admin')
@section('title', 'Manual Reservation')
@section('page-title', 'Manual Reservation')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="panel">
      <div class="panel-header">
        <h5><i class="fas fa-calendar-plus me-2" style="color:var(--gold)"></i>Create Manual Reservation</h5>
        <a href="{{ route('admin.transactions') }}" class="btn btn-sm btn-outline-secondary">
          <i class="fas fa-arrow-left me-1"></i>Back
        </a>
      </div>
      <div class="panel-body">
        <form method="POST" action="{{ route('admin.reservations.store') }}" id="manualResvForm">
          @csrf

          <div class="row g-3 mb-3">
            <div class="col-md-12">
              <label class="form-label">Guest Account</label>
              <select name="user_id" class="form-select" required>
                <option value="">— Select a guest —</option>
                @foreach($users as $u)
                  <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>
                    {{ $u->name }} ({{ $u->email }})
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Check-In Date</label>
              <input type="date" name="check_in" id="adminCheckIn" class="form-control"
                     value="{{ old('check_in') }}" min="{{ now()->format('Y-m-d') }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Check-Out Date</label>
              <input type="date" name="check_out" id="adminCheckOut" class="form-control"
                     value="{{ old('check_out') }}" required>
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Room Type</label>
              <select name="room_type_id" id="adminRoomType" class="form-select" required>
                <option value="">— Select room type —</option>
                @foreach($roomTypes as $rt)
                  <option value="{{ $rt->id }}">{{ $rt->name }} (Rp {{ number_format($rt->price_per_night,0,',','.') }}/night)</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Available Room</label>
              <select name="room_id" id="adminRoomId" class="form-select" required>
                <option value="">— Select dates &amp; type first —</option>
              </select>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label">Notes (Optional)</label>
            <textarea name="notes" class="form-control" rows="3" placeholder="Special requests or admin notes…">{{ old('notes') }}</textarea>
          </div>

          <div class="alert alert-info" style="font-size:.85rem">
            <i class="fas fa-info-circle me-2"></i>
            Admin reservations are automatically set to <strong>Active</strong> status and do not require payment.
          </div>

          <div class="d-flex gap-3">
            <a href="{{ route('admin.transactions') }}" class="btn-gold-outline flex-grow-1 justify-content-center" style="padding:.7rem">Cancel</a>
            <button type="submit" class="btn-gold flex-grow-1 justify-content-center" style="padding:.7rem">
              <i class="fas fa-calendar-check me-2"></i>Create Reservation
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  const checkIn    = document.getElementById('adminCheckIn');
  const checkOut   = document.getElementById('adminCheckOut');
  const roomType   = document.getElementById('adminRoomType');
  const roomSelect = document.getElementById('adminRoomId');

  function loadRooms() {
    const rtId = roomType.value;
    const ci   = checkIn.value;
    const co   = checkOut.value;

    if (!rtId || !ci || !co) return;

    roomSelect.innerHTML = '<option>Loading…</option>';

    fetch(`{{ route('admin.reservations.available-rooms') }}?room_type_id=${rtId}&check_in=${ci}&check_out=${co}`)
      .then(r => r.json())
      .then(rooms => {
        roomSelect.innerHTML = '<option value="">— Select a room —</option>';
        if (rooms.length === 0) {
          roomSelect.innerHTML = '<option value="" disabled>No rooms available</option>';
        } else {
          rooms.forEach(r => {
            roomSelect.innerHTML += `<option value="${r.id}">${r.room_number} (${r.view_type} view)</option>`;
          });
        }
      })
      .catch(() => {
        roomSelect.innerHTML = '<option value="" disabled>Error loading rooms</option>';
      });
  }

  checkIn.addEventListener('change', () => {
    if (checkIn.value) {
      const min = new Date(checkIn.value);
      min.setDate(min.getDate() + 1);
      checkOut.min = min.toISOString().split('T')[0];
    }
    loadRooms();
  });
  checkOut.addEventListener('change', loadRooms);
  roomType.addEventListener('change', loadRooms);
</script>
@endpush
