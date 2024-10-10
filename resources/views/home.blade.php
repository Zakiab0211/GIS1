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

// /**pakai google streets */
// googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
//     maxZoom: 20,
//     subdomains:['mt0','mt1','mt2','mt3']
// }).addTo(map);

// /**pakai open streetmap */
// L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
//     maxZoom: 19,
//     attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
// }).addTo(map);

// /**pakai open googleHybrid */
// googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
//     maxZoom: 20,
//     subdomains:['mt0','mt1','mt2','mt3']
// }).addTo(map);

// Hybrid: s,h;
// Satellite: s;
// Streets: m;
// Terrain: p;
/////////////////////////////////////////////////////
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
////////////////////////////////////////

    // L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
    //     maxZoom: 20,
    //     subdomains:['mt0','mt1','mt2','mt3']
    // }).addTo(map);

    var LeafIcon = L.Icon.extend({
    options: {
    iconSize:     [30, 40], // ukuran ikon (lebih kecil)
    shadowSize:   [40, 50], // ukuran bayangan (disesuaikan)
    iconAnchor:   [15, 40], // titik jangkar ikon (tengah bawah ikon)
    shadowAnchor: [10, 50],  // titik jangkar bayangan (disesuaikan)
    popupAnchor:  [0, -35] // titik dari mana popup dibuka relatif ke iconAnchor
    }
});




/**fungsi untuk klik langtitude and longtitude */
// function onMapClick(e) {
//     alert("anda mengklik " + e.latlng);
// }

// map.on('click', onMapClick);

$( document ).ready(function() {
    $.getJSON('titik/json', function (data) {

    $.each(data, function(index) {
        // alert(data[index])

        var marker = L.marker([parseFloat(data[index].latitude),parseFloat(data[index].longtitude)], {icon: user1}).addTo(map);
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


$.getJSON('assets/geojson/map.geojson', function(data){

});

// $.getJSON('titik/lokasi'+feature.properties.id, function(detail){
//     $.each(detail, function(index){
//         var html='<div><h5> Nama : '+detail[index].nama+'</h5>';
//             html+='<h6>Alamat : '+detail[index].alamat+'</h6>';
//             html+='<img height="100px" src="assets/images/'+detail[index].gambar+'"></div>';
//         L.popup()
//             .setLatLng(layer.getBounds().getCenter())
//             .setContent(custom-popup)
//             .openOn(map);
            
//         });

// })

// Menambahkan marker di titik [-7.313974, 112.737495] dan menampilkan informasi dari database
// $.getJSON('titik/lokasi/'+feature.properties.id, function(detail) {
//     $.each(detail, function(index) {
//         // Buat konten HTML untuk ditampilkan di dalam popup
//         var html = '<div><h5> Nama: ' + detail[index].nama + '</h5>';
//         html += '<h6>Alamat: ' + detail[index].alamat + '</h6>';
//         html += '<img height="100px" src="assets/images/' + detail[index].gambar + '"></div>';

//         // Buat marker di lokasi [-7.313974, 112.737495]
//         var marker = L.marker([-7.313974, 112.737495]).addTo(map);

//         // Tampilkan popup di marker tersebut
//         marker.bindPopup(custom-popup).openPopup();
//     });
// });

//////////////
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
        // alert(feature.properties.nama)
        // var cIcon = L.divicon({
        //             className: 'label-bidang',
        //             html: '<b>'+feature.properties.nama'</br>',
        //             iconSize: [100, 20]

        // });
// Menambahkan marker di tengah setiap layer
var marker = L.marker(layer.getBounds().getCenter(), {icon: flag1}).addTo(map);
//var marker = L.marker([-7.2727028137165775, 112.8025511510512], {icon: flag1}).addTo(map);

// Mengambil ID dan keterangan dari `data[index]`
//var  = feature.properties.suhu;  // Atur sesuai dengan struktur JSON

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


/*fungsi untuk mengcustom marker pada titik peta */
L.icon = function (options) {
    return new L.Icon(options);
};
var grenarea1 = new LeafIcon({iconUrl: 'GIS/app/assets/icons/grenarea.png'}),
    location1 = new LeafIcon({iconUrl: 'GIS/app/assets/icons/location.png'}),
    as = new LeafIcon({iconUrl: 'GIS/app/assets/icons/jay.png'}),
    user1 = new LeafIcon({iconUrl: 'GIS/app/assets/icons/user.png'});
    
    L.marker([-7.275755, 112.7973779], {icon: grenarea1}).addTo(map).bindPopup('<div class="custom-popup"><h3>Smart Weather</h3><p>Suhu: 28°C<br>Kelembapan: 70%<br>Cuaca: Cerah</p></div>');
    L.marker([-7.275431, 112.796391], {icon: location1}).addTo(map).bindPopup('<div class="custom-popup"><h3>Smart Soil</h3><p>Kondisi Tanah: Optimal<br>pH Tanah: 6.5</p></div>');
    L.marker([-7.275815, 112.799137], {icon: as}).addTo(map).bindPopup('<div class="custom-popup"><h3>Smart OPT</h3><p>Deteksi dini hama dan penyakit tanaman.</p></div>');

</script>

</html>

