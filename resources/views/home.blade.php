<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>

     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

     <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

     
      <style>
        /* #map { height: 500px; } */
        html, body {
			height: 100%;
			margin: 0;
			padding: 0;
		}
		#map {
			height: 100%;
			width: 100%;
		}
		.custom-popup {
			font-family: Arial, sans-serif;
			font-size: 14px;
			line-height: 1.5;
		}
		.custom-popup h3 {
			margin-top: 0;
			color: #007BFF;
		}

     </style>

</head>
<body>
<div id="map"></div>
</body>

<script>
var map = L.map('map').setView([-7.279090, 112.792796], 7);

/*Layer untuk Google Hybrid*/
var googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3']
    });

    var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3']
    });

    // Layer untuk OpenStreetMap
    var openStreetMap = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    });

    // Menambahkan kontrol layer untuk memungkinkan pergantian peta dasar
    var baseMaps = {
        "Streets": googleStreets,
        "traffic": openStreetMap,
        "satelite": googleHybrid
    };

    L.control.layers(baseMaps).addTo(map);
    // Set Google Streets sebagai default layer yang ditampilkan saat halaman dimuat
    googleHybrid.addTo(map);

    var LeafIcon = L.Icon.extend({
    options: {
    iconSize:     [30, 40], // ukuran ikon (lebih kecil)
    shadowSize:   [40, 50], // ukuran bayangan (disesuaikan)
    iconAnchor:   [15, 40], // titik jangkar ikon (tengah bawah ikon)
    shadowAnchor: [10, 50],  // titik jangkar bayangan (disesuaikan)
    popupAnchor:  [0, -35] // titik dari mana popup dibuka relatif ke iconAnchor
    }
});



$( document ).ready(function() {
    $.getJSON('titik/json', function (data) {

    $.each(data, function(index) {
        // alert(data[index])

        var marker = L.marker([parseFloat(data[index].latitude),parseFloat(data[index].longtitude)]).addTo(map);
        /*ini kalo ambil satu parameter yang di tampilkan*/
        //marker.bindPopup('<b>Rekomendasi</b><p></p>' + data[index].Rekomendasi);
        // Gabungkan semua konten yang ingin ditampilkan di popup
        var popupContent = 
                '<div class="custom-popup">' +
                '<h3><b>Smart Agri</b></h3>' +
                '<p><b>Tempat: </b></p>' + data[index].nama + '' + 
                '<p><b>Rekomendasi: </b></p>' + data[index].Rekomendasi + '' +  // Tampilkan rekomendasi
                '<p><b>Keterangan: </b></p>' + data[index].keterangan + '' +  // Tampilkan keterangan
                '</div>';

            // Bind popup dengan konten gabungan
            marker.bindPopup(popupContent);

    });

    });

});

$( document ).ready(function() {
    $.getJSON('kondisi/lokasi', function (data) {

    $.each(data, function(index) {
        // alert(data[index])

        var marker = L.marker([parseFloat(data[index].latitude),parseFloat(data[index].longtitude)]).addTo(map);
        /*ini kalo ambil satu parameter yang di tampilkan*/
        //marker.bindPopup('<b>Rekomendasi</b><p></p>' + data[index].Rekomendasi);
        // Gabungkan semua konten yang ingin ditampilkan di popup
        var popupContent = 
                '<div class="custom-popup">' +
                '<h3><b>Smart Irigat</b></h3>' +
                '<p><b>Nama: </b></p>' + data[index].nama + '' + 
                '<p><b>Wilayah: </b></p>' + data[index].alamat + '' +  // Tampilkan rekomendasi
                //'<p><b>Gambar: </b></p>' + data[index].gambar + '' +  // Tampilkan keterangan
                //'<img src="' + data[index].gambar + '" alt="Gambar" style="width:100%; height:auto;">' +  // Tampilkan gambar
                '<img src="gambara.JPG" alt="Gambar" style="width:100%; height:auto;">' +  // Tampilkan gambar
                '</div>';

            // Bind popup dengan konten gabungan
            marker.bindPopup(popupContent);

    });

    });

});

$.getJSON('assets/geojson/map.geojson', function(data){

});

$.getJSON('assets/geojson/map.geojson', function(json){
    geoLayer = L.geoJson(json,{
        style: function(feature){
        return{
            fillOpacity: 0.5,
            weight: 5,
            opacity: 1,
            color:"blue",
            dashArray: "30 10",
            lineCap: 'square'
        };
    },
    onEachFeature: function(feature, layer){

// Menambahkan marker di tengah setiap layer
var marker = L.marker(layer.getBounds().getCenter()).addTo(map);
//var marker = L.marker([-7.2727028137165775, 112.8025511510512], {icon: flag1}).addTo(map);


// Mengambil ID atau properti lainnya dari GeoJSON
var popupContent1 = 
    '<div class="custom-popup">' +
    '<h3><b>Lokasi</b></h3>' +
    '<p><b>suhu: </b>' + feature.properties.suhu + '</p>' +  // Tampilkan ID dari properti GeoJSON
    '<p><b>kelembapan: </b>' + feature.properties.kelembapan +'</p>' + // Tampilkan keterangan tambahan
    '</div>';
    // Bind popup dengan konten gabungan
    marker.bindPopup(popupContent1);


    // Menambahkan layer ke map
    layer.addTo(map);
    }
    
    });

});

$( document ).ready(function() {
    $.getJSON('titik/json', function (data) {

    $.each(data, function(index) {
        // alert(data[index])

        var marker = L.marker([parseFloat(data[index].latitude),parseFloat(data[index].longtitude)]).addTo(map);
        /*ini kalo ambil satu parameter yang di tampilkan*/
        //marker.bindPopup('<b>Rekomendasi</b><p></p>' + data[index].Rekomendasi);
        // Gabungkan semua konten yang ingin ditampilkan di popup
        var popupContent = 
                '<div class="custom-popup">' +
                '<h3><b>Smart Agri</b></h3>' +
                '<p><b>Tempat: </b></p>' + data[index].nama + '' + 
                '<p><b>Rekomendasi: </b></p>' + data[index].Rekomendasi + '' +  // Tampilkan rekomendasi
                '<p><b>Keterangan: </b></p>' + data[index].keterangan + '' +  // Tampilkan keterangan
                '</div>';

            // Bind popup dengan konten gabungan
            marker.bindPopup(popupContent);

    });

    });

});


/*fungsi untuk mengcustom marker pada titik peta */
L.icon = function (options) {
    return new L.Icon(options);
};
var grenarea1 = new LeafIcon({iconUrl: 'img src="assets/icons/grenarea.png" alt="Gambar"'}),
    location1 = new LeafIcon({iconUrl: 'GIS/app/assets/icons/location.png'}),
    as = new LeafIcon({iconUrl: 'GIS/app/assets/icons/jay.png'}),
    user1 = new LeafIcon({iconUrl: 'GIS/app/assets/icons/user.png'});
    
    L.marker([-7.275755, 112.7973779], {icon: grenarea1}).addTo(map).bindPopup('<div class="custom-popup"><h3>Smart Weather</h3><p>Suhu: 28°C<br>Kelembapan: 70%<br>Cuaca: Cerah</p></div>');
    L.marker([-7.275431, 112.796391]).addTo(map).bindPopup('<div class="custom-popup"><h3>Smart Soil</h3><p>Kondisi Tanah: Optimal<br>pH Tanah: 6.5</p></div>');
    L.marker([-7.275815, 112.799137]).addTo(map).bindPopup('<div class="custom-popup"><h3>Smart OPT</h3><p>Deteksi dini hama dan penyakit tanaman.</p></div>');

</script>

</html>




<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced Map Dashboard</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

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
        }
        .custom-popup {
            font-size: 14px;
            line-height: 1.5;
        }
        .custom-popup h3 {
            margin-top: 0;
            color: #007BFF;
        }
        .legend {
            background: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        .legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 8px;
            opacity: 0.7;
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
        #crud-form {
            margin-top: 20px;
        }
        #crud-form input, #crud-form button {
            margin-bottom: 10px;
            width: 100%;
            padding: 5px;
        }
    </style>
</head>
<body>
<div id="map-container">
    <div id="sidebar">
        <h2>GeoInfo</h2>
        <button class="nav-button" onclick="showMarkers('weather')"><i class="fas fa-cloud-sun"></i> Smart Weather</button>
        <button class="nav-button" onclick="showMarkers('soil')"><i class="fas fa-seedling"></i> Smart Soil</button>
        <button class="nav-button" onclick="showMarkers('opt')"><i class="fas fa-bug"></i> Smart OPT</button>
        
        <div id="crud-form">
            <h3>Add/Edit Marker</h3>
            <input type="text" id="marker-name" placeholder="Marker Name">
            <input type="text" id="marker-lat" placeholder="Latitude">
            <input type="text" id="marker-lng" placeholder="Longitude">
            <input type="text" id="marker-type" placeholder="Type (weather/soil/opt)">
            <button onclick="addMarker()">Add Marker</button>
            <button onclick="updateMarker()">Update Marker</button>
            <button onclick="deleteMarker()">Delete Marker</button>
        </div>
    </div>
    <div id="map"></div>
</div>

<script>
var map = L.map('map').setView([-7.279090, 112.792796], 7);

var googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']
});

var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']
});

var openStreetMap = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
});

var baseMaps = {
    "Streets": googleStreets,
    "Traffic": openStreetMap,
    "Satellite": googleHybrid
};

L.control.layers(baseMaps).addTo(map);
googleHybrid.addTo(map);

var LeafIcon = L.Icon.extend({
    options: {
        iconSize:     [30, 40],
        shadowSize:   [40, 50],
        iconAnchor:   [15, 40],
        shadowAnchor: [10, 50],
        popupAnchor:  [0, -35]
    }
});

var weatherIcon = new LeafIcon({iconUrl: 'GIS/app/assets/icons/grenarea.png'}),
    soilIcon = new LeafIcon({iconUrl: 'GIS/app/assets/icons/location.png'}),
    optIcon = new LeafIcon({iconUrl: 'GIS/app/assets/icons/jay.png'});

var markers = {
    weather: L.layerGroup(),
    soil: L.layerGroup(),
    opt: L.layerGroup()
};

function addMarkerToMap(lat, lng, type, name, additionalInfo) {
    var icon;
    var layer;
    switch(type) {
        case 'weather':
            icon = weatherIcon;
            layer = markers.weather;
            break;
        case 'soil':
            icon = soilIcon;
            layer = markers.soil;
            break;
        case 'opt':
            icon = optIcon;
            layer = markers.opt;
            break;
        default:
            icon = new L.Icon.Default();
            layer = map;
    }

    var marker = L.marker([lat, lng]).addTo(layer);
    var popupContent = `<div class="custom-popup"><h3>${name}</h3><p>${additionalInfo}</p></div>`;
    marker.bindPopup(popupContent);
}

// Initial markers
addMarkerToMap(-7.275755, 112.7973779, 'weather', 'Smart Weather', 'Suhu: 28°C<br>Kelembapan: 70%<br>Cuaca: Cerah');
addMarkerToMap(-7.275431, 112.796391, 'soil', 'Smart Soil', 'Kondisi Tanah: Optimal<br>pH Tanah: 6.5');
addMarkerToMap(-7.275815, 112.799137, 'opt', 'Smart OPT', 'Deteksi dini hama dan penyakit tanaman.');

// Add all layers to the map initially
Object.values(markers).forEach(layer => map.addLayer(layer));

function showMarkers(type) {
    Object.entries(markers).forEach(([key, layer]) => {
        if (key === type) {
            map.addLayer(layer);
        } else {
            map.removeLayer(layer);
        }
    });
}

// Legend
var legend = L.control({position: 'bottomright'});

legend.onAdd = function (map) {
    var div = L.DomUtil.create('div', 'info legend');
    var types = ['weather', 'soil', 'opt'];
    var labels = ['Smart Weather', 'Smart Soil', 'Smart OPT'];
    var colors = ['#ff7800', '#98ff00', '#0078ff'];

    for (var i = 0; i < types.length; i++) {
        div.innerHTML +=
            '<i style="background:' + colors[i] + '"></i> ' + labels[i] + '<br>';
    }

    return div;
};

legend.addTo(map);

// CRUD Operations
function addMarker() {
    var name = document.getElementById('marker-name').value;
    var lat = parseFloat(document.getElementById('marker-lat').value);
    var lng = parseFloat(document.getElementById('marker-lng').value);
    var type = document.getElementById('marker-type').value;

    if (name && !isNaN(lat) && !isNaN(lng) && type) {
        addMarkerToMap(lat, lng, type, name, 'New marker');
        // Here you would typically also send this data to your server to update the database
        alert('Marker added successfully!');
    } else {
        alert('Please fill all fields correctly.');
    }
}

function updateMarker() {
    // In a real application, you'd need to select a specific marker to update
    alert('Update functionality would go here. You need to implement a way to select specific markers.');
}

function deleteMarker() {
    // In a real application, you'd need to select a specific marker to delete
    alert('Delete functionality would go here. You need to implement a way to select specific markers.');
}

// Load markers from database
function loadMarkersFromDatabase() {
    // This is where you'd typically make an AJAX call to your server to get marker data
    // For this example, we'll use dummy data
    var dummyData = [
        {lat: -7.276, lng: 112.798, type: 'weather', name: 'Weather Station 1', info: 'Temp: 30°C'},
        {lat: -7.277, lng: 112.797, type: 'soil', name: 'Soil Sensor 1', info: 'pH: 6.8'},
        {lat: -7.278, lng: 112.796, type: 'opt', name: 'OPT Station 1', info: 'No pests detected'}
    ];

    dummyData.forEach(marker => {
        addMarkerToMap(marker.lat, marker.lng, marker.type, marker.name, marker.info);
    });
}

// Call this function when the page loads
loadMarkersFromDatabase();

</script>
</body>
</html> -->