var map;
var geocoder;
var marker = [];
var infoWindow = [];

var markerData = JSON.parse($('input#placeValue').val());
var placeLat = parseFloat($('#placeLat').val());
var placeLng = parseFloat($('#placeLng').val());
let css_style = '';

function initMap() {

    var mapLatLng = new google.maps.LatLng({lat: parseFloat(markerData['lat']), lng: parseFloat(markerData['lng'])});
    map = new google.maps.Map(document.getElementById('map'), {
        center: mapLatLng,
        zoom: +setting_scale
    });

    markerLatLng = new google.maps.LatLng({lat: parseFloat(markerData['lat']), lng: parseFloat(markerData['lng'])});
    marker = new google.maps.Marker({
        position: markerLatLng,
        map: map
    });

    if(parseFloat(markerData['full_status'])) {
        markerData['total_person'] = markerData['total_place'];
        markerData['percent'] = 100;
    }

    if(markerData['percent'] > 100) {
        markerData['percent'] = 100;
    }

    if(markerData['total_person'] > markerData['total_place']) {
        markerData['total_person'] = markerData['total_place']
    }

    infoWindow = new google.maps.InfoWindow({
        content: '<div class="map">' +
            '<div class="placeName">'+ place_name +  ': ' + markerData['name'] + '</div><br/>' +
            '<div class="placeAddress">' + place_address + ': ' + markerData['address_place'] + '</div><br/>' +
            '<div class="placeIno">' + place_capacity + ': ' + markerData['total_person'] + ' / ' + markerData['total_place'] +  place_people + '</div><br/>' +
            '<div class="placePrecent">' + place_percent + ': ' + markerData['percent'] + '%</div>' +
            '</div>'
    });

    markerEvent(i);

    marker.setOptions({
        icon: {
            url: '/images/map_active.png'
        }
    });
}

function markerEvent() {
    marker.addListener('click', function() {
        infoWindow.open(map, marker);
    });
}

function loadMap() {

    var mapLatLng = new google.maps.LatLng({lat: placeLat, lng: placeLng});
    map = new google.maps.Map(document.getElementById('map'), {
        center: mapLatLng,
        zoom: +setting_scale
    });


    markerLatLng = new google.maps.LatLng({lat: placeLat, lng: placeLng});
    marker = new google.maps.Marker({
        position: markerLatLng,
        map: map
    });

    infoWindow = new google.maps.InfoWindow({
        content: ''
    });

    markerEvent();


}

$(function () {
    $('#submit').on('keypress click', function (e) {
        address = $('#address').val();
        geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            'address': address
        }, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: results[0].geometry.location,
                    zoom: +setting_scale
                });
                marker = new google.maps.Marker({
                    position: results[0].geometry.location,
                    map: map
                });

                $("input#latitude").val(results[0].geometry.location.lat());
                $("input#longitude").val(results[0].geometry.location.lng());

            } else {
                alert( 'Geocode was not successful for the following reason: ' + status );
            }
        });

    });
});
