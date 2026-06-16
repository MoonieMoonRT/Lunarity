@extends('layouts.admin')
@section('title', 'Booking Calendar')
@section('page-title', 'Booking Calendar')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css">
@endpush

@section('content')

<div class="panel mb-3">
  <div class="panel-body" style="padding:.75rem 1.5rem">
    <div class="d-flex flex-wrap gap-3 align-items-center">
      <span style="font-size:.82rem;font-weight:600;color:var(--navy)">Legend:</span>
      @foreach([['#2a9d8f','Active'],['#e9c46a','Pending'],['#264653','Completed']] as [$c,$l])
        <span style="display:flex;align-items:center;gap:.4rem;font-size:.82rem;color:var(--navy)">
          <span style="width:12px;height:12px;border-radius:3px;background:{{ $c }};display:inline-block"></span>{{ $l }}
        </span>
      @endforeach
      <div class="ms-auto">
        <a href="{{ route('admin.reservations.create') }}" class="btn-gold" style="padding:.45rem 1rem;font-size:.82rem">
          <i class="fas fa-plus me-1"></i>New Reservation
        </a>
      </div>
    </div>
  </div>
</div>

<div class="panel">
  <div class="panel-body">
    <div id="bookingCalendar" style="min-height:600px"></div>
  </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const cal = new FullCalendar.Calendar(document.getElementById('bookingCalendar'), {
    initialView: 'dayGridMonth',
    headerToolbar: {
      left:   'prev,next today',
      center: 'title',
      right:  'dayGridMonth,timeGridWeek,listMonth'
    },
    events: {
      url: '{{ route("admin.calendar.data") }}',
      method: 'GET',
      failure: () => alert('Could not load calendar data.')
    },
    eventClick: (info) => {
      if (info.event.url) {
        info.jsEvent.preventDefault();
        window.location.href = info.event.url;
      }
    },
    eventDisplay: 'block',
    dayMaxEvents: 3,
    height: 'auto'
  });
  cal.render();
});
</script>
@endpush
