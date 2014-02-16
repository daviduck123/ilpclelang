$(document).ready(function() {
    $('.carousel').carousel({
        interval: 2000
    });
    $('#carousel-example-generic').on('slid.bs.carousel', function(event) {
        var active = $(event.target).find('.carousel-inner > .item.active');
        var from = active.index();
        var next = $(event.relatedTarget);
        var to = next.index();
        loadgraph(from);
    });
});