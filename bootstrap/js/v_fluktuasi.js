var loader = new Worker(SITE_URL + 'bootstrap/js/fluktuasi.js');
function tampil_fluktuasi(jam) {
    loader.postMessage(jam);
}
loader.onmessage = function(event) {
    update_graph();
};
window.onload = function() {
    var waktu = TIME_SERVER;
    tampil_jam(waktu);
    tampil_fluktuasi(waktu);
}
function print_r(arr, level) {
    var dumped_text = "";
    if (!level)
        level = 0;
    var level_padding = "";
    for (var j = 0; j < level + 1; j++)
        level_padding += "    ";
    if (typeof (arr) == 'object') {
        for (var item in arr) {
            var value = arr[item];
            if (typeof (value) == 'object') { //If it is an array,
                dumped_text += level_padding + "'" + item + "' ...\n";
                dumped_text += print_r(value, level + 1);
            } else {
                dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
            }
        }
    } else { //Stings/Chars/Numbers etc.
        dumped_text = "===>" + arr + "<===(" + typeof (arr) + ")";
    }
    return dumped_text;
}

var update_graph = function() {
    var strurl = "ajax/fluktuasi";
    var csrf = $("input[name=csrf_token_name]").val();
    $.ajax({
        dataType: "json",
        data: {csrf_token_name: csrf},
        type: "POST",
        url: URL + strurl,
        success: function(result) {
            DATA = result;
            loadgraph(0);
            update_table();
        }
    });
};
var update_table = function() {
    var strurl = "ajax/hargaAkhir";
    var harga = null;
    var csrf = $("input[name=csrf_token_name]").val();
    $.ajax({
        dataType: "json",
        data: {csrf_token_name: csrf},
        type: "POST",
        url: URL + strurl,
        success: function(result) {
            harga = result;
            implent_table(harga);
        }
    });
    
};
var implent_table = function(source){
    $('#harga_kayu').html(numeral(source["kayu"]).format('0,0'));
    $('#harga_besi').html(numeral(source["besi"]).format('0,0'));
    $('#harga_batu').html(numeral(source["batubata"]).format('0,0'));
    $('#harga_semen').html(numeral(source["semen"]).format('0,0'));
    $('#harga_tanah').html(numeral(source["tanah"]).format('0,0'));
    $('#harga_plastik').html(numeral(source["plastik"]).format('0,0'));
    $('#harga_kaca').html(numeral(source["kaca"]).format('0,0'));
    $('#harga_air').html(numeral(source["air"]).format('0,0'));
    $('#harga_karet').html(numeral(source["karet"]).format('0,0'));
};