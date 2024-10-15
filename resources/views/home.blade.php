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
var grenarea1 = new LeafIcon({iconUrl: 'GIS/app/assets/icons/grenarea.png'}),
    location1 = new LeafIcon({iconUrl: 'GIS/app/assets/icons/location.png'}),
    as = new LeafIcon({iconUrl: 'GIS/app/assets/icons/jay.png'}),
    user1 = new LeafIcon({iconUrl: 'GIS/app/assets/icons/user.png'});
    
    L.marker([-7.275755, 112.7973779]).addTo(map).bindPopup('<div class="custom-popup"><h3>Smart Weather</h3><p>Suhu: 28°C<br>Kelembapan: 70%<br>Cuaca: Cerah</p></div>');
    L.marker([-7.275431, 112.796391]).addTo(map).bindPopup('<div class="custom-popup"><h3>Smart Soil</h3><p>Kondisi Tanah: Optimal<br>pH Tanah: 6.5</p></div>');
    L.marker([-7.275815, 112.799137]).addTo(map).bindPopup('<div class="custom-popup"><h3>Smart OPT</h3><p>Deteksi dini hama dan penyakit tanaman.</p></div>');

</script>

</html>