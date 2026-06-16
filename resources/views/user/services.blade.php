@extends('layouts.user')
@section('title', 'Hotel Services')
@section('page-title', 'Hotel Service Numbers')

@section('content')

<div class="section-header text-start mb-4">
  <div class="section-label">Internal Phone Directory</div>
  <h2 class="section-title" style="font-size:1.8rem">Hotel Services</h2>
  <div class="section-divider" style="margin:0 0 .5rem"></div>
  <p style="font-size:.9rem;color:var(--text-muted)">
    Dial any extension from your in-room phone. Available 24/7.
  </p>
</div>

<div class="row g-3">
  @foreach($services as $svc)
    @if($svc->is_easter_egg)
      <div class="col-md-6 col-lg-4">
        <a href="{{ $svc->easter_egg_url }}" target="_blank" class="service-card easter-egg">
          <div class="service-ext">{{ $svc->extension }}</div>
          <div>
            <div style="font-weight:700;font-size:.95rem;color:#ff4444">{{ $svc->department }}</div>
            <div style="font-size:.82rem;color:#cc3333;margin-top:.2rem">{{ $svc->description }}</div>
          </div>
          <i class="fas fa-skull ms-auto" style="color:#ff4444;font-size:1.2rem"></i>
        </a>
      </div>
    @else
      <div class="col-md-6 col-lg-4">
        <div class="service-card">
          <div class="service-ext">{{ $svc->extension }}</div>
          <div>
            <div style="font-weight:600;color:var(--navy)">{{ $svc->department }}</div>
            <div style="font-size:.82rem;color:var(--text-muted);margin-top:.2rem">{{ $svc->description }}</div>
          </div>
          <i class="fas fa-phone ms-auto" style="color:var(--gold);font-size:.9rem"></i>
        </div>
      </div>
    @endif
  @endforeach
</div>

<div class="panel mt-4" style="border-color:rgba(201,168,76,.25);background:rgba(201,168,76,0.04)">
  <div class="panel-body" style="font-size:.85rem;color:var(--text-muted)">
    <i class="fas fa-info-circle me-2" style="color:var(--gold)"></i>
    To call a service from your room phone, simply pick up the handset and dial the extension number directly.
    For emergencies, dial extension <strong>5</strong> (Security) or <strong>0</strong> for the operator.
  </div>
</div>

@endsection
