<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

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
    
    L.marker([-7.275755, 112.7973779]).addTo(map).bindPopup('<div class="custom-popup"><h3>Smart Weather</h3><p>Suhu: 28°C<br>Kelembapan: 70%<br>Cuaca: Cerah</p></div>');
    L.marker([-7.275431, 112.796391]).addTo(map).bindPopup('<div class="custom-popup"><h3>Smart Soil</h3><p>Kondisi Tanah: Optimal<br>pH Tanah: 6.5</p></div>');
    L.marker([-7.275815, 112.799137]).addTo(map).bindPopup('<div class="custom-popup"><h3>Smart HPT</h3><p>Deteksi dini hama dan penyakit tanaman.</p></div>');

</script>
</html> -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

     <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

     <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        #map-container {
            display: flex; /* Use flexbox to layout the sidebar and map */
            height: 100%;
        }
        #sidebar {
            width: 250px; /* Set the width of the sidebar */
            background-color: #F5F5DC; /* Light background for contrast */
            padding: 10px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1); /* Optional shadow for depth */
        }
        #map {
            flex-grow: 1; /* Make map take remaining space */
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

     </style>

</head>
<body>
<div id="map-container">
    <div id="sidebar">
        <h2>GIS Smart Agriculture</h2>
        <button class="nav-button" data-type="smart_soil">Smart Soil</button>
        <button class="nav-button" data-type="smart_irigation">Smart Irrigation</button>
        <button class="nav-button" data-type="smart_hpt">Smart HPT</button>
        <button class="nav-button" data-type="smart_weather">Smart Weather</button>
        <button class="nav-button" data-type="land_mapping">Pemetaan Lahan</button>
    </div>
    <div id="map"></div>
</div>
<script>
var map = L.map('map').setView([-7.279090, 112.792796], 7);

// Layer untuk Google Hybrid
var googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
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
    "Streets": openStreetMap,
    "Satellite": googleHybrid
};

L.control.layers(baseMaps).addTo(map);
googleHybrid.addTo(map);

// Array untuk menyimpan marker
var smartSoilMarkers = [];
var smartIrrigationMarkers = [];
var smartHPTMarkers = [];
var smartWeatherMarkers = [];
var landMappingMarkers = []; // Array untuk Pemetaan Lahan

// Fungsi untuk menampilkan marker sesuai dengan tipe
function showMarkers(type) {
    // Sembunyikan semua marker
    hideAllMarkers();

    // Tampilkan marker sesuai tipe
    if (type === 'smart_soil') {
        smartSoilMarkers.forEach(marker => marker.addTo(map));
    } else if (type === 'smart_irigation') {
        smartIrrigationMarkers.forEach(marker => marker.addTo(map));
    } else if (type === 'smart_hpt') {
        smartHPTMarkers.forEach(marker => marker.addTo(map));
    } else if (type === 'smart_weather') {
        smartWeatherMarkers.forEach(marker => marker.addTo(map));
    } else if (type === 'land_mapping') {
        landMappingMarkers.forEach(marker => marker.addTo(map));
    }
}

// Fungsi untuk menyembunyikan semua marker
function hideAllMarkers() {
    smartSoilMarkers.forEach(marker => map.removeLayer(marker));
    smartIrrigationMarkers.forEach(marker => map.removeLayer(marker));
    smartHPTMarkers.forEach(marker => map.removeLayer(marker));
    smartWeatherMarkers.forEach(marker => map.removeLayer(marker));
    landMappingMarkers.forEach(marker => map.removeLayer(marker)); // Tambahkan ini
}

// Menambahkan marker untuk Smart Soil
$.getJSON('titik/json', function(data) {
    $.each(data, function(index) {
        var marker = L.marker([parseFloat(data[index].latitude), parseFloat(data[index].longtitude)]);
        var popupContent = 
            '<div class="custom-popup">' +
            '<h3><b>Smart Soil</b></h3>' +
            '<p><b>Tempat: </b></p>' + data[index].nama + '' + 
            '<p><b>Rekomendasi: </b></p>' + data[index].Rekomendasi + '' +  
            '<p><b>Keterangan: </b></p>' + data[index].keterangan + 
            '</div>';
        marker.bindPopup(popupContent);
        smartSoilMarkers.push(marker); // Simpan marker
    });
});

// Menambahkan marker untuk Smart Irrigation
 $.getJSON('kondisi/lokasi', function(data) {
     $.each(data, function(index) {
         var marker = L.marker([parseFloat(data[index].latitude), parseFloat(data[index].longtitude)]);
         var popupContent = 
             '<div class="custom-popup">' +
             '<h3><b>Smart Irigation</b></h3>' +
             '<p><b>Nama: </b></p>' + data[index].nama + '' + 
             '<p><b>Wilayah: </b></p>' + data[index].alamat + 
            //'<img src="http://localhost/GIS/public/img/gambara.JPG' + data[index].gambar + '.JPG" alt="Gambar" style="width:100%; height:auto;">' +  
             '</div>';
         marker.bindPopup(popupContent);
         smartIrrigationMarkers.push(marker); // Simpan marker
     });
 });
$.getJSON('kondisi/lokasi', function(data) {
    $.each(data, function(index) {
        var latitude = parseFloat(data[index].latitude);
        var longitude = parseFloat(data[index].longtitude);
        var nama = data[index].nama;
        var alamat = data[index].alamat;
        var gambar = data[index].gambar; // Pastikan ini ada

        console.log('Gambar path: ', 'public/img/' + gambar + '.JPG'); // Debugging path gambar
        console.log('Gambar: ', gambar); // Debugging nilai gambar

        var marker = L.marker([latitude, longitude]);
        var popupContent = 
            '<div class="custom-popup">' +
            '<h3><b>Smart Irrigation</b></h3>' +
            '<p><b>Nama: </b>' + (nama || 'Tidak ada nama') + '</p>' + 
            '<p><b>Wilayah: </b>' + (alamat || 'Tidak ada alamat') + '</p>' + 
            '<img src="public/img/' + gambar + '.JPG" alt="gambar" style="width:100%; height:auto;">' +  
            '</div>';
        
        marker.bindPopup(popupContent);
        smartIrrigationMarkers.push(marker); // Simpan marker
    });
});

// GeoJSON Layer
$.getJSON('assets/geojson/map.geojson', function(json){
    geoLayer = L.geoJson(json, {
        style: function(feature) {
            return {
                fillOpacity: 0.5,
                weight: 5,
                opacity: 1,
                color: "blue",
                dashArray: "30 10",
                lineCap: 'square'
            };
        },
        onEachFeature: function(feature, layer) {
            var marker = L.marker(layer.getBounds().getCenter());
            var popupContent1 = 
                '<div class="custom-popup">' +
                '<h3><b>Lokasi</b></h3>' +
                '<p><b>suhu: </b>' + feature.properties.suhu + '</p>' +
                '<p><b>kelembapan: </b>' + feature.properties.kelembapan + '</p>' +
                '</div>';
            marker.bindPopup(popupContent1);
            landMappingMarkers.push(marker); // Simpan marker
            marker.addTo(map); // Tambahkan marker ke peta
        }
    }).addTo(map); // Tambahkan geoLayer ke peta
});

// Marker manual
var smartWeatherMarker = L.marker([-7.275755, 112.7973779]).bindPopup('<div class="custom-popup"><h3>Smart Weather</h3><p>Suhu: 28°C<br>Kelembapan: 70%<br>Cuaca: Cerah</p></div>');
var smartSoilMarker = L.marker([-7.275431, 112.796391]).bindPopup('<div class="custom-popup"><h3>Smart Soil</h3><p>Nama: Tanah A<br>pH: 6.5</p></div>');
var smartHPTMarker = L.marker([-7.280896, 112.795530]).bindPopup('<div class="custom-popup"><h3>Smart HPT</h3><p>Nama: HPT A<br>Status: Aktif</p></div>');

// Simpan marker manual
smartWeatherMarkers.push(smartWeatherMarker);
smartSoilMarkers.push(smartSoilMarker);
smartHPTMarkers.push(smartHPTMarker);

// Event listener untuk tombol
$('.nav-button').click(function() {
    var type = $(this).data('type');
    showMarkers(type);
});
</script>
</body>
</html>

