
var serverDate;
onmessage = function(event) {
    serverDate = new Date(event.data);
};
function getServerDate() {
    serverDate = new Date(time); //server date and time, change server-side code accordingly
}

function tick() {
    serverDate.setSeconds(serverDate.getSeconds() + 1);
    var min = serverDate.getMinutes();
    if (min < 10)
        min = "0" + min;
    var sec = serverDate.getSeconds();
    if (sec < 10)
        sec = "0" + sec;
    if (sec >= 59)
    {
        postMessage("true");
    }
}

setInterval("tick()", 1000);