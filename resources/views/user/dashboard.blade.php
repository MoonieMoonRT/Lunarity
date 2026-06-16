@extends('layouts.user')
@section('title', 'Room Facilities')
@section('page-title', 'Room Facilities')

@section('content')

<div class="section-header text-start mb-4">
  <div class="section-label">Our Collection</div>
  <h2 class="section-title" style="font-size:1.8rem">Choose Your Room</h2>
  <div class="section-divider" style="margin:0"></div>
</div>

<div class="row g-4">
  @foreach($roomTypes as $type)
  <div class="col-md-4">
    <div class="room-card h-100">
      <img src="{{ $type->image_url }}" alt="{{ $type->name }}" class="room-card-image">
      <div class="room-card-body">
        <span class="badge mb-2" style="background:rgba(201,168,76,0.12);color:var(--gold-dark);font-size:.72rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;padding:.35rem .75rem;border-radius:50px">
          {{ strtoupper($type->slug) }}
        </span>
        <h5 style="font-family:'Playfair Display',serif;color:var(--navy);margin-bottom:.5rem">{{ $type->name }}</h5>
        <p style="font-size:.88rem;color:#64748B;line-height:1.7;margin-bottom:1rem">{{ $type->short_description }}</p>

        <div class="d-flex align-items-center gap-2 mb-1">
          <i class="fas fa-user-friends" style="color:var(--gold);font-size:.85rem"></i>
          <span style="font-size:.82rem;color:var(--text-muted)">Up to {{ $type->max_capacity }} guests</span>
        </div>

        <div class="room-price mt-2">
          Rp {{ number_format($type->price_per_night, 0, ',', '.') }}
          <small>/night</small>
        </div>

        <div class="d-flex gap-2 mt-3">
          <form method="POST" action="{{ route('user.wishlist.add') }}" class="flex-grow-1">
            @csrf
            <input type="hidden" name="room_type_id" value="{{ $type->id }}">
            <button type="submit" class="btn-gold w-100 justify-content-center" style="padding:.6rem">
              <i class="fas fa-plus me-1"></i> Add to Wishlist
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>

{{-- Wishlist Summary Card --}}
@if($activeWishlist && $activeWishlist->items->count() > 0)
<div class="panel mt-4">
  <div class="panel-header">
    <h5><i class="fas fa-heart me-2" style="color:var(--gold)"></i>Your Wishlist ({{ $wishlistCount }} room(s))</h5>
    <a href="{{ route('user.transactions') }}" class="btn-gold" style="padding:.45rem 1.1rem;font-size:.85rem">
      <i class="fas fa-arrow-right me-1"></i>Proceed to Book
    </a>
  </div>
  <div class="panel-body">
    <div class="d-flex flex-wrap gap-2">
      @foreach($activeWishlist->items as $item)
        <span class="badge" style="background:var(--navy);color:var(--gold-light);padding:.5rem .9rem;border-radius:8px;font-size:.85rem">
          {{ $item->roomType->name }} × {{ $item->quantity }}
        </span>
      @endforeach
    </div>
  </div>
</div>
@endif

@endsection
