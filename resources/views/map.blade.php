<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Agriculture GIS</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        #map-container {
            display: flex;
            height: 100%;
        }
        #sidebar {
            width: 300px;
            padding: 20px;
            background-color: #f0f0f0;
            overflow-y: auto;
        }
        #map {
            flex-grow: 1;
            height: 100%;
        }
        .custom-popup {
            font-size: 14px;
            line-height: 1.5;
        }
        .custom-popup h3 {
            margin-top: 0;
            color: #007BFF;
        }
        .nav-button {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: left;
        }
        .nav-button:hover {
            background-color: #0056b3;
        }
        #marker-form {
            margin-top: 20px;
        }
        #marker-form input, #marker-form select, #marker-form button {
            margin-bottom: 10px;
            width: 100%;
            padding: 5px;
        }
    </style>
</head>
<body>
<div id="map-container">
    <div id="sidebar">
        <h2>Smart Agriculture GIS</h2>
        <button class="nav-button" data-type="smart_soil"><i class="fas fa-seedling"></i> Smart Soil</button>
        <button class="nav-button" data-type="smart_irrigation"><i class="fas fa-tint"></i> Smart Irrigation</button>
        <button class="nav-button" data-type="smart_hpt"><i class="fas fa-bug"></i> Smart HPT</button>
        <button class="nav-button" data-type="smart_weather"><i class="fas fa-cloud-sun"></i> Smart Weather</button>
        <button class="nav-button" data-type="land_mapping"><i class="fas fa-map"></i> Pemetaan Lahan</button>
        
        <div id="marker-form">
            <h3>Tambah/Edit Marker</h3>
            <input type="hidden" id="marker-id">
            <input type="text" id="marker-name" placeholder="Nama Lokasi">
            <input type="text" id="marker-lat" placeholder="Latitude">
            <input type="text" id="marker-lng" placeholder="Longitude">
            <select id="marker-type">
                <option value="smart_soil">Smart Soil</option>
                <option value="smart_irrigation">Smart Irrigation</option>
                <option value="smart_hpt">Smart HPT</option>
                <option value="smart_weather">Smart Weather</option>
                <option value="land_mapping">Pemetaan Lahan</option>
            </select>
            <textarea id="marker-description" placeholder="Deskripsi"></textarea>
            <button onclick="saveMarker()">Simpan Marker</button>
            <button onclick="deleteMarker()" class="delete-btn">Hapus Marker</button>
        </div>

        <div class="marker-list" id="marker-list">
            <!-- Marker list will be populated here -->
        </div>
    </div>
    <div id="map"></div>
</div>

<script>
var map = L.map('map').setView([-7.279090, 112.792796], 7);

// Add OpenStreetMap tile layer
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap'
}).addTo(map);

// Custom icons for different types
var icons = {
    smart_soil: L.icon({iconUrl: 'path/to/soil.png', iconSize: [25, 41], iconAnchor: [12, 41]}),
    smart_irrigation: L.icon({iconUrl: 'path/to/irrigation.png', iconSize: [25, 41], iconAnchor: [12, 41]}),
    smart_hpt: L.icon({iconUrl: 'path/to/pest.png', iconSize: [25, 41], iconAnchor: [12, 41]}),
    smart_weather: L.icon({iconUrl: 'path/to/weather.png', iconSize: [25, 41], iconAnchor: [12, 41]}),
    land_mapping: L.icon({iconUrl: 'path/to/land.png', iconSize: [25, 41], iconAnchor: [12, 41]})
};

// Load markers from database
function loadMarkers(type = null) {
    $.get(`/markers/${type || ''}`, function(data) {
        // Clear existing markers
        Object.values(markerLayers).forEach(layer => layer.clearLayers());
        
        data.forEach(marker => {
            addMarkerToMap(marker);
            addMarkerToList(marker);
        });
    });
}

// Add marker to map
function addMarkerToMap(markerData) {
    var marker = L.marker([markerData.latitude, markerData.longitude], {
        icon: icons[markerData.type]
    }).addTo(markerLayers[markerData.type]);

    var popupContent = `
        <div class="custom-popup">
            <h3>${markerData.name}</h3>
            <p>${markerData.description || ''}</p>
            <button onclick="editMarker(${markerData.id})">Edit</button>
        </div>
    `;
    marker.bindPopup(popupContent);
    return marker;
}

// Event listeners
$('.nav-button').click(function() {
    $('.nav-button').removeClass('active');
    $(this).addClass('active');
    var type = $(this).data('type');
    loadMarkers(type);
});

$(document).ready(function() {
    loadMarkers();
});

// Allow clicking on map to set coordinates
map.on('click', function(e) {
    $('#marker-lat').val(e.latlng.lat);
    $('#marker-lng').val(e.latlng.lng);
});
</script>
</body>
</html>
