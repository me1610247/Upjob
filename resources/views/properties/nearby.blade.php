@extends('front.layouts.app')

@section('main')
<section class="">
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <h2 class="fw-bold text-primary">
                        <i class="fas fa-map-marker-alt"></i> You are in area: {{ $userArea }}
                    </h2>
                    <p class="text-muted">Showing properties near your location</p>
                    
                    <div id="map" style="height: 300px; width: 100%;" class="rounded-3 my-4"></div>
                </div>
            </div>
            <h3 class="fw-bold mb-4">Nearby Properties</h3>
            
            @if($properties->count() > 0)
                <div class="row g-4">
                    @foreach($properties as $property)
                        <div class="col-md-6 col-lg-4">
                            <div class="card property-card h-100">
                                @php
                                $staticImages = [
                                    'assets/properties/prop1 (1).jpg',
                                    'assets/properties/prop1 (2).jpg',
                                    'assets/properties/prop1 (3).jpg',
                                    'assets/properties/prop1 (4).jpg',
                                    'assets/properties/prop1 (5).jpg',
                                    'assets/properties/prop1 (6).jpg',
                                    'assets/properties/prop1 (7).jpg',
                                    'assets/properties/prop1 (8).jpg',
                                    'assets/properties/prop1 (9).jpg',
                                    'assets/properties/prop1 (10).jpg',
                                    'assets/properties/prop1 (11).jpg',
                                    'assets/properties/prop1 (12).jpg',
                                    'assets/properties/prop1 (13).jpg',
                                    'assets/properties/prop1 (14).jpg',
                                    'assets/properties/prop1 (15).jpg',
                                    'assets/properties/prop1 (16).jpg',
                                    'assets/properties/prop1 (17).jpg',
                                    'assets/properties/prop1 (18).jpg',
                                ];
                                $randomImage = $staticImages[array_rand($staticImages)];
                            @endphp
                        <img src="{{ asset($randomImage) }}" class="card-img-top" alt="Static Property Image" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">{{ $property->title }}</h5>
                                    <p class="text-muted">
                                        <i class="fas fa-map-marker-alt"></i> {{ $property->location }}
                                    </p>
                                    <div class="property-features mb-3">
                                        <span class="badge bg-primary me-1">{{ $property->category->name }}</span>
                                        <span class="badge bg-secondary">{{ $property->jobType->name }}</span>
                                    </div>
                                    @if($property->salary)
                                        <p class="fw-bold text-success">EGP {{ number_format($property->salary) }}</p>
                                    @endif
                                    <a href="{{ route('details', $property->id) }}" class="btn btn-primary w-100">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    No properties available in your area currently
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Leaflet Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    // Display map with user location and properties
    document.addEventListener('DOMContentLoaded', function() {
        const map = L.map('map').setView([{{ $userLat }}, {{ $userLon }}], 14);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Add marker for user location
        L.marker([{{ $userLat }}, {{ $userLon }}])
            .addTo(map)
            .bindPopup('Your current location')
            .openPopup();
    });
</script>

<style>
    .property-card {
        transition: transform 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
    }
    .property-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .property-image {
        height: 200px;
        object-fit: cover;
    }
</style>
</section>
