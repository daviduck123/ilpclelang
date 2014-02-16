var DATA = null;
var loadgraph = function(index) {
    var datagraph = DATA[index]["data"];
    $("#titlegraph-" + index).html(DATA[index]["id"]);
    $("#point-" + index).attr("title",DATA[index]["id"]);
    $('#graph-' + index).html('');
    new Morris.Line({
        // ID of the element in which to draw the chart.
        element: "graph-" + index,
        // Chart data records -- each entry in this array corresponds to a point on
        // the chart.
        xkey: 'id',
        ykeys: ["angka"],
        labels: [DATA[index]["id"]],
        data: datagraph,
        parseTime: false,
        smooth: false,
        gridTextColor: "black",
        goalLineColors: ["black"]
        // The name of the data record attribute that contains x-values.
    });
};