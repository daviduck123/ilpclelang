
var loadgraph = function() {
    $('#graph').html('');
    new Morris.Line({
        // ID of the element in which to draw the chart.
        element: 'graph',
        // Chart data records -- each entry in this array corresponds to a point on
        // the chart.
        data: DATA,
        hideHover: false,
        parseTime: false,
        // The name of the data record attribute that contains x-values.
        xkey: 'id',
        // A list of names of data record attributes that contain y-values.
        ykeys: ['kayu', 'besi', 'batubata', 'semen', 'tanah', 'plastik', 'kaca', 'air', 'karet'],
        // Labels for the ykeys -- will be displayed when you hover over the
        // chart.
        labels: ['kayu', 'besi', 'batu bata', 'semen', 'tanah', 'plastik', 'kaca', 'air', 'karet'],
        ymin: '600'
    });
};