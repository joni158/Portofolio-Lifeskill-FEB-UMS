function ajaxkota(a) {
    var b = "select_region?prop=" + a + "&sid=" + Math.random();
    ajaxku.onreadystatechange = stateChanged, ajaxku.open("GET", b, !0), ajaxku.send(null)
}

function ajaxkec(a) {
    var b = "select_region?kab=" + a + "&sid=" + Math.random();
    ajaxku.onreadystatechange = stateChangedKec, ajaxku.open("GET", b, !0), ajaxku.send(null)
}

function ajaxkel(a) {
    var b = "select_region?kec=" + a + "&sid=" + Math.random();
    ajaxku.onreadystatechange = stateChangedKel, ajaxku.open("GET", b, !0), ajaxku.send(null)
}

function buatajax() {
    return window.XMLHttpRequest ? new XMLHttpRequest : window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : null
}

function stateChanged() {
    var a;
    4 == ajaxku.readyState && (a = ajaxku.responseText, a.length >= 0 ? document.getElementById("kota").innerHTML = a : document.getElementById("kota").value = "<option selected>Pilih Kota/Kab</option>")
}

function stateChangedKec() {
    var a;
    4 == ajaxku.readyState && (a = ajaxku.responseText, a.length >= 0 ? document.getElementById("kec").innerHTML = a : document.getElementById("kec").value = "<option selected>Pilih Kecamatan</option>")
}

function stateChangedKel() {
    var a;
    4 == ajaxku.readyState && (a = ajaxku.responseText, a.length >= 0 ? document.getElementById("kel").innerHTML = a : document.getElementById("kel").value = "<option selected>Pilih Kelurahan/Desa</option>")
}

function initialize() {
    geocoder = new google.maps.Geocoder
}

function showCoordinate() {
    var a = document.getElementById("prop"),
        b = document.getElementById("kota"),
        c = document.getElementById("kec"),
        d = document.getElementById("kel"),
        e = d.options[d.selectedIndex].text + ", " + c.options[c.selectedIndex].text;
    s2 = e + ", " + b.options[b.selectedIndex].text + ", " + a.options[a.selectedIndex].text, geocoder.geocode({
        address: e
    }, function(e, f) {
        if (f == google.maps.GeocoderStatus.OK) {
            var g = e[0].geometry.location;
            $(location).attr("href", "?prov=" + a.value + "&kab=" + b.value + "&kec=" + c.value + "&kel=" + d.value+"&p=" + g)
        } else swal("Terjadi kesalahan", "Geocode was not successful for the following reason:)'" + f + "'", "error")
    })
}
var ajaxku = buatajax(),
    geocoder;
google.maps.event.addDomListener(window, "load", initialize);
