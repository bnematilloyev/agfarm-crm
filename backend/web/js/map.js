let coords = getInitialCoords();
let mymap = L.map('mapid').setView(coords, 13);
let marker = L.marker(coords).addTo(mymap);

L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1Ijoibm9vcmV5MTIzIiwiYSI6ImNrZ3J1ZTYzdTA1a2EyeW1uMjk3dmgxcWoifQ.TO_m6Jw1MxE74yKCBIWVsg', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 20,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'your.mapbox.access.token'
}).addTo(mymap);

function getInitialCoords() {
    // Creating the map.
    let coords = [41.311151, 69.279737];

    let lat = $('#lat').val();
    let lng = $('#lng').val();

    if (lat && lng) {
        coords = getCoordsFromLatLng(lat, lng);
    }
    return coords;
}

function getCoordsFromLatLng(lat, lng) {
    let coords = [];
    coords.push(lat);
    coords.push(lng);
    return coords;
}

function onMapClick(e) {
    marker.setLatLng(e.latlng);
    $('#lat').val(e.latlng['lat']);
    $('#lng').val(e.latlng['lng']);
}

function changeMapLocation(lat, lng) {
    mymap.setZoomAround({
        "lat": lat,
        "lng": lng
    }, 14);
    marker.setLatLng({
        "lat": lat,
        "lng": lng
    });
}


function setInputLatAndLng(__el, __event, __selecton ){
    // https://maps.google.com/maps?q=41.311033,69.249413&ll=41.311033,69.249413&z=16
    //https://www.google.com/maps/place/%D0%91%D0%B5%D0%BB%D1%8B%D0%B9+%D0%B4%D0%BE%D0%BC,+%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD/@42.4838707,70.2394264,10z/data=!4m5!3m4!1s0x38ae9762479dd967:0xaef39b66a47563bf!8m2!3d41.4914136!4d69.0999699
    //https://yandex.com/maps/org/tashkent_city_park/132543039073/?ll=69.248322%2C41.316406&z=17

    $(__el).on(__event,function() {
        let selectedMap = $(__selecton).val();
        let map = $(this).val();
        // let prefix = el.attr('id').replace('product_id', '');
        if (selectedMap==1){
            let latFirstIndex = Number(map.indexOf("=") + 1);
            let latLastIndex = Number(map.indexOf(","));
            let longFirstIndex = Number(map.indexOf(",") + 1);
            let longLastIndex = Number(map.indexOf("&"));
            let lat = map.substring(latFirstIndex, latLastIndex);
            let long = map.substring(longFirstIndex, longLastIndex);
            if (map.charAt(29)=="q"){
                console.log(map.charAt(latFirstIndex-1));
                console.log(latFirstIndex);
                $("#lat").val(lat);
                $("#lng").val(long);
                changeMapLocation(lat, long);
            }else{
                alert("Вы поместили неправильную ссылку");
                $("#lat").val("");
                $("#lng").val("");
            }
            // https://www.google.com/maps/place/Uzbekiston/@41.311118,69.2508763,17z/data=!3m1!4b1!4m5!3m4!1s0x38ae8b1aa47cb363:0x8a726bd3277791f2!8m2!3d41.311118!4d69.253065
        }else if (selectedMap==2){
            let latFirstIndex = Number(map.indexOf("@") + 1);
            let latLastIndex = Number(map.indexOf(","));
            let longFirstIndex = Number(map.indexOf(",") + 1);
            let longLastIndex = Number(map.indexOf(",1"));
            let long = map.substring(longLastIndex, longFirstIndex);
            let lat = map.substring(latLastIndex, latFirstIndex );
            if (map.includes("place")){
                console.log(map.indexOf("/@"));
                console.log(map.charAt(map.indexOf("@")));
                console.log(Number(map.indexOf(",")));
                console.log(lat);
                $("#lat").val(lat);
                $("#lng").val(long);
                changeMapLocation(lat, long);
            }else{
                alert("Вы поместили неправильную ссылку");
                $("#lat").val("");
                $("#lng").val("");
            }
        } else if (selectedMap==3){
            let latFirstIndex = Number(map.indexOf("C") + 1);
            let latLastIndex = Number(map.indexOf("&"));
            let longFirstIndex  = Number(map.indexOf("=") + 1);
            let longLastIndex = Number(map.indexOf("%"));
            let long = map.substring(longFirstIndex, longLastIndex);
            let lat = map.substring(latFirstIndex, latLastIndex);
            if (map.charAt(latLastIndex)==="&"){
                $("#lat").val(lat);
                $("#lng").val(long);
                changeMapLocation(lat, long);
            } else{
                alert("Вы поместили неправильную ссылку");
                $("#lat").val("");
                $("#lng").val("");
            }
        }
    });
}

setInputLatAndLng("#map_coordinate", "blur", "#map_selections");

mymap.on('click', onMapClick);