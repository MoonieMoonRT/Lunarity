@extends('layouts.app')
@section('title', 'The Lunarity — Luxury Hotel Experience')

@section('content')

{{-- ── HERO ─────────────────────────────────── --}}
<section class="hero-section" id="hero">
  <div>
    <div class="hero-badge">✦ Award-Winning Luxury Hotel ✦</div>
    <h1 class="hero-title">
      Where Elegance<br>
      <span class="gold-text">Meets Serenity</span>
    </h1>
    <p class="hero-subtitle">
      Experience the pinnacle of luxury hospitality at The Lunarity —
      your sanctuary of refinement in the heart of the city.
    </p>
    <div class="d-flex gap-3 justify-content-center flex-wrap">
      @auth
        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard') }}"
           class="btn-gold" style="padding:.8rem 2rem;font-size:1rem">
          <i class="fas fa-th-large me-2"></i>Go to Dashboard
        </a>
      @else
        <a href="{{ route('register') }}" class="btn-gold" style="padding:.8rem 2rem;font-size:1rem">
          <i class="fas fa-door-open me-2"></i>Explore Rooms
        </a>
        <a href="{{ route('login') }}" class="btn-gold-outline" style="padding:.8rem 2rem;font-size:1rem">
          <i class="fas fa-sign-in-alt me-2"></i>Sign In
        </a>
      @endauth
    </div>
  </div>
</section>

{{-- ── QUICK STATS ────────────────────────────── --}}
<section style="background:var(--navy);padding:2rem 0;border-top:1px solid var(--navy-border);border-bottom:1px solid var(--navy-border)">
  <div class="container">
    <div class="row text-center gy-3">
      @foreach([['24','Rooms Available'],['5★','Star Rating'],['15+','Years Experience'],['10k+','Happy Guests']] as $stat)
      <div class="col-6 col-md-3">
        <div style="color:var(--gold);font-family:'Playfair Display',serif;font-size:2rem;font-weight:700">{{ $stat[0] }}</div>
        <div style="color:var(--text-light);font-size:.82rem;letter-spacing:.06em;text-transform:uppercase">{{ $stat[1] }}</div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ── FACILITIES ──────────────────────────────── --}}
<section style="padding:5rem 0;background:var(--off-white)" id="facilities">
  <div class="container-fluid px-4 px-md-5">
    <div class="section-header">
      <div class="section-label">Our Offerings</div>
      <h2 class="section-title">Curated Facilities & Rooms</h2>
      <div class="section-divider"></div>
    </div>

    {{-- Card 1: Standard Room (image left) --}}
    <div class="facility-row">
      <div class="facility-image"
           style="background-image:url('https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=900&q=80')">
      </div>
      <div class="facility-content">
        <div class="facility-type">Accommodation</div>
        <h3>Standard Room</h3>
        <p>A comfortable and elegantly designed room with plush bedding, private en-suite bathroom with rainfall shower, and a dedicated work desk. Ideal for both business and leisure guests seeking a relaxing retreat. Room size: 28 sqm.</p>
        <div>
          <span class="facility-tag"><i class="fas fa-wifi me-1"></i>Free WiFi</span>
          <span class="facility-tag"><i class="fas fa-snowflake me-1"></i>AC</span>
          <span class="facility-tag"><i class="fas fa-tv me-1"></i>Smart TV</span>
          <span class="facility-tag">From Rp 850.000/night</span>
        </div>
      </div>
    </div>

    {{-- Card 2: Deluxe Room (content left) --}}
    <div class="facility-row reverse">
      <div class="facility-image"
           style="background-image:url('https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=900&q=80')">
      </div>
      <div class="facility-content">
        <div class="facility-type">Premium Accommodation</div>
        <h3>Deluxe Room</h3>
        <p>Elevated luxury featuring a king-size bed with premium linens, a separate soaking tub, panoramic city or sea views, complimentary minibar, and a Nespresso machine. Enjoy dedicated concierge service throughout your stay. Room size: 42 sqm.</p>
        <div>
          <span class="facility-tag"><i class="fas fa-bath me-1"></i>Soaking Tub</span>
          <span class="facility-tag"><i class="fas fa-cocktail me-1"></i>Minibar</span>
          <span class="facility-tag"><i class="fas fa-concierge-bell me-1"></i>Concierge</span>
          <span class="facility-tag">From Rp 1.500.000/night</span>
        </div>
      </div>
    </div>

    {{-- Card 3: Suite (image left) --}}
    <div class="facility-row">
      <div class="facility-image"
           style="background-image:url('https://images.unsplash.com/photo-1590490360182-c33d57733427?w=900&q=80')">
      </div>
      <div class="facility-content">
        <div class="facility-type">Ultimate Luxury</div>
        <h3>Suite Room</h3>
        <p>The pinnacle of our accommodation offering — a lavish sanctuary with a separate living room, walk-in closet, private Jacuzzi, and an expansive balcony with breathtaking views. Bespoke butler service and exclusive lounge access included. Room size: 75 sqm.</p>
        <div>
          <span class="facility-tag"><i class="fas fa-hot-tub me-1"></i>Private Jacuzzi</span>
          <span class="facility-tag"><i class="fas fa-user-tie me-1"></i>Butler Service</span>
          <span class="facility-tag"><i class="fas fa-glass-cheers me-1"></i>Lounge Access</span>
          <span class="facility-tag">From Rp 3.200.000/night</span>
        </div>
      </div>
    </div>

    {{-- Card 4: Restaurant (content left) --}}
    <div class="facility-row reverse">
      <div class="facility-image"
           style="background-image:url('https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=900&q=80')">
      </div>
      <div class="facility-content">
        <div class="facility-type">Dining</div>
        <h3>Open Kitchen Restaurant</h3>
        <p>Our signature restaurant features an open kitchen concept where you can witness master chefs craft exquisite dishes before your eyes. From local Indonesian delicacies to international cuisine, experience a culinary journey that tantalizes all senses. Open daily 06:00 – 23:00.</p>
        <div>
          <span class="facility-tag"><i class="fas fa-utensils me-1"></i>Fine Dining</span>
          <span class="facility-tag"><i class="fas fa-wine-glass me-1"></i>Wine Bar</span>
          <span class="facility-tag"><i class="fas fa-birthday-cake me-1"></i>Private Events</span>
          <span class="facility-tag">Room Service Available</span>
        </div>
      </div>
    </div>

    {{-- Card 5: Other Facilities (image left) --}}
    <div class="facility-row">
      <div class="facility-image"
           style="background-image:url('https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=900&q=80')">
      </div>
      <div class="facility-content">
        <div class="facility-type">Recreation & Wellness</div>
        <h3>Hotel Amenities</h3>
        <p>Beyond accommodation, The Lunarity offers a complete resort experience with world-class recreational and wellness facilities designed to refresh your body and mind.</p>
        <div class="row g-2 mt-2">
          @foreach([
            ['fas fa-swimming-pool','Infinity Pool'],
            ['fas fa-dumbbell','Fitness Center'],
            ['fas fa-glass-martini-alt','Rooftop Lounge'],
            ['fas fa-wifi','High-Speed WiFi'],
            ['fas fa-parking','Valet Parking'],
            ['fas fa-spa','Spa & Wellness'],
          ] as [$ico, $label])
          <div class="col-6">
            <div style="display:flex;align-items:center;gap:.6rem;font-size:.88rem;color:var(--text-light)">
              <i class="{{ $ico }}" style="color:var(--gold);width:16px"></i> {{ $label }}
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>

  </div>
</section>

{{-- ── CTA ─────────────────────────────────────── --}}
<section style="background:var(--navy);padding:5rem 2rem;text-align:center">
  <div class="container">
    <div style="color:var(--gold);font-size:.8rem;letter-spacing:.14em;text-transform:uppercase;margin-bottom:.75rem">Book Your Stay</div>
    <h2 style="font-family:'Playfair Display',serif;color:var(--white);font-size:2.5rem;margin-bottom:1rem">
      Your Luxury Escape Awaits
    </h2>
    <p style="color:var(--text-light);max-width:500px;margin:0 auto 2rem;font-size:.95rem">
      Join thousands of discerning guests who have experienced The Lunarity difference.
    </p>
    @guest
      <a href="{{ route('register') }}" class="btn-gold" style="padding:.9rem 2.5rem;font-size:1rem;margin-right:.75rem">
        <i class="fas fa-door-open me-2"></i>Reserve Now
      </a>
      <a href="{{ route('login') }}" class="btn-gold-outline" style="padding:.9rem 2rem;font-size:1rem">
        Sign In
      </a>
    @else
      <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard') }}"
         class="btn-gold" style="padding:.9rem 2.5rem;font-size:1rem">
        <i class="fas fa-th-large me-2"></i>Go to Dashboard
      </a>
    @endguest
  </div>
</section>

@endsection
