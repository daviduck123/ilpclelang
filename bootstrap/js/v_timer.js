var clock = new Worker(SITE_URL + 'bootstrap/js/clock.js');
function tampil_jam(jam) {
    clock.postMessage(jam);
}
clock.onmessage = function(event) {
    document.getElementById("jam").innerHTML = "Jam Server : " + event.data;
};
window.onload = function() {
    var waktu = TIME_SERVER;
    tampil_jam(waktu);
}