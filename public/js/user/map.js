var map;
var geocoder;
var marker = [];
var infoWindow = [];

var markerData = JSON.parse($('input#placeValues').val());
let css_style = '';
let image_map = '';
let percent = '';
let total_person = '';

function initMap() {

    var mapLatLng = new google.maps.LatLng({lat: parseFloat(getLatitudeDefault), lng: parseFloat(getLongitudeDefault)});
    map = new google.maps.Map(document.getElementById('map'), {
        center: mapLatLng,
        zoom: +setting_scale
    });

    for (var i = 0; i < markerData.length; i++) {
        if(parseFloat(markerData[i]['full_status'])) {
            css_style = 'bg-violet';
            image_map = '/images/map_active_full.png';
            percent = 100;
            total_person = markerData[i]['total_place'];

        } else  {
            if(parseFloat(markerData[i]['percent']) > 80) {
                css_style = 'bg-violet';
                image_map = '/images/map_active_full.png';
            }
            if(parseFloat(markerData[i]['percent']) <= 80 && parseFloat(markerData[i]['percent']) >= 50) {
                css_style = 'bg-danger';
                image_map = '/images/map_active_red.png';
            }
            if(parseFloat(markerData[i]['percent']) < 50) {
                css_style = 'bg-success';
                image_map = '/images/map_active_blue.png';
            }

            percent = markerData[i]['percent'];
            if(percent > 100) {
                percent = 100;
            }

            total_person = markerData[i]['total_person'];
            if(total_person > markerData[i]['total_place']) {
                total_person = markerData[i]['total_place'];
            }
        }

        markerLatLng = new google.maps.LatLng({lat: parseFloat(markerData[i]['lat']), lng: parseFloat(markerData[i]['lng'])});
        marker[i] = new google.maps.Marker({
            position: markerLatLng,
            map: map,
            label: {
                text: markerData[i]['name'],
                className: 'custom_label'
            },
            icon: image_map
        });

        if(markerData[i]['active_flg']) {

            infoWindow[i] = new google.maps.InfoWindow({
                content: '<div class="map">' +
                    '<div class="placeName">'+ place_name +  ': ' + markerData[i]['name'] + '</div><br/>' +
                    '<div class="placeAddress">' + place_address + ': ' + markerData[i]['address_place'] + '</div><br/>' +
                    '<div class="placeIno">' + place_capacity + ': ' + total_person + ' / ' + markerData[i]['total_place'] +  place_people + '</div><br/>' +
                    '<div class="placePrecent">' + place_percent + ': ' + percent + '%</div><br/>' +
                    '<div class="altitude">' + altitude + ': ' + markerData[i]['altitude'] + '</div>' +
                    '</div>'
            });

        } else {
            infoWindow[i] = new google.maps.InfoWindow({
                content: '<div class="map">CLOSE</div>'
                });

            marker[i].setOptions({
                icon: {
                    url: '/images/map_inactive_gray.png'
                },
            });
        }

        markerEvent(i);
        css_style = '';
        image_map = '';
        percent = '';
        total_person = '';
    }

}

function markerEvent(i) {
    marker[i].addListener('click', function() {
        for (var j = 0; j < markerData.length; j++) {
            infoWindow[j].close();
        }
        var centerMap = new google.maps.LatLng(parseFloat(markerData[i]['lat']), parseFloat(markerData[i]['lng']));
        map.setCenter(centerMap);
        window.setTimeout(function() {map.setZoom(+setting_scale);},500);
        infoWindow[i].open(map, marker[i]);
    });
}


function getLocation() {

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            // Success function
            foundLocation,
            // Error function
            showError,
            // Options
            {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            });
    } else {
            alert( 'Could not find location');
        }
}

function foundLocation(position) {
    var lat = position.coords.latitude;
    var lon = position.coords.longitude;

    var mapLatLng = new google.maps.LatLng({lat: lat, lng: lon});
    map = new google.maps.Map(document.getElementById('map'), {
        center: mapLatLng,
        zoom: +setting_scale
    });

    markerLatLng = new google.maps.LatLng({lat: lat, lng: lon});
    marker = new google.maps.Marker({
        position: markerLatLng,
        map: map,
    });

    marker.setOptions({
        icon: {
            url: 'images/my_location.png'
        }
    });


    for (var i = 0; i < markerData.length; i++) {
        if(parseFloat(markerData[i]['full_status'])) {
            css_style = 'bg-violet';
            image_map = '/images/map_active_full.png';
            percent = 100;
            total_person = markerData[i]['total_place'];
        } else  {
            if(parseFloat(markerData[i]['percent']) > 80) {
                css_style = 'bg-violet';
                image_map = '/images/map_active_full.png';
            }
            if(parseFloat(markerData[i]['percent']) <= 80 && parseFloat(markerData[i]['percent']) >= 50) {
                css_style = 'bg-danger';
                image_map = '/images/map_active_red.png';
            }
            if(parseFloat(markerData[i]['percent']) < 50) {
                css_style = 'bg-success';
                image_map = '/images/map_active_blue.png';
            }
            percent = markerData[i]['percent'];
            total_person = markerData[i]['total_person'];
        }

        markerLatLng = new google.maps.LatLng({lat: parseFloat(markerData[i]['lat']), lng: parseFloat(markerData[i]['lng'])});
        marker[i] = new google.maps.Marker({
            position: markerLatLng,
            map: map,
            label: {
                text: markerData[i]['name'],
                className: 'custom_label'
            },
            icon: image_map
        });


        if(markerData[i]['active_flg']) {

            infoWindow[i] = new google.maps.InfoWindow({
                content: '<div class="map">' +
                    '<div class="placeName">'+ place_name +  ': ' + markerData[i]['name'] + '</div><br/>' +
                    '<div class="placeAddress">' + place_address + ': ' + markerData[i]['address_place'] + '</div><br/>' +
                    '<div class="placeIno">' + place_capacity + ': ' + total_person + ' / ' + markerData[i]['total_place'] +  place_people + '</div><br/>' +
                    '<div class="placePrecent">' + place_percent + ': ' + percent + '%</div><br/>' +
                    '<div class="altitude">' + altitude + ': ' + markerData[i]['altitude'] + '</div>' +
                    '</div>'
            });

        } else {
            infoWindow[i] = new google.maps.InfoWindow({
                content: '<div class="map">CLOSE</div>'
            });
            marker[i].setOptions({
                icon: {
                    url: '/images/map_inactive_gray.png'
                }
            });
        }

        markerEvent(i);
        css_style = '';
        image_map = '';
        percent = '';
        total_person = '';
    }
}

function getPlace(lat, lng)
{
    var centerMap = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
    map.setCenter(centerMap);
    window.setTimeout(function() {map.setZoom(+setting_scale);},500);
}

function showError(error) {
    alert('Could not find location');
}


