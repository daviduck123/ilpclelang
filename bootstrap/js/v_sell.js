$(document).ready(function() {
    $(".inputData").keyup(function() {
        var id = $(this).attr('id');
        var data = id.split('_');
        var index = data[1];
        var angka = $(this).val();
        angka = numeral().unformat(angka);
        var harga = numeral().unformat($("#harga_" + index).html());
        var hasil = angka * harga;
        var hasil = numeral(hasil).format('0,0');
        $("#item_" + index + "_total").html(hasil);
        checkStatusBarang();
        hitungTotalJumlah();
    });

});
var checkStatusBarang = function() {
    var data = $(".inputData");
    var kondisi = true;
    data.each(function() {
        var index = ($(this).attr('id')).split('_');
        index = index[1];
        var input = numeral().unformat($(this).val());
        var stok = numeral().unformat($("#jumlah_" + index).html());
        if ((input > stok) && (kondisi)) {
            kondisi = false;
        }
    });
    if (!kondisi) {
        $("#grandTotal").removeClass("red green");
        $("#grandTotal").addClass("red");
        $("#tombol_jual").prop('disabled', true);
    } else {
        $("#grandTotal").removeClass("red green");
        $("#grandTotal").addClass("green");
        $("#tombol_jual").prop('disabled', false);
    }
};
var hitungTotalJumlah = function() {
    var data = $(".TotalHitung");
    var total = 0;
    data.each(function() {
        total += numeral().unformat($(this).html());
    });
    var uangPeserta = numeral().unformat($("#uangPeserta").html());
    $("#grandTotal1").val(total);
    total = numeral(total).format('0,0');
    $("#grandTotal").html(total);

};
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
};
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
;
var update_graph = function() {
    var strurl = "ajax/hargaAkhir";
    var csrf = $("input[name=csrf_token_name]").val();
    $.ajax({
        dataType: "json",
        data: {csrf_token_name: csrf},
        type: "POST",
        url: URL + strurl,
        success: function(result) {
            update_table(result);
        }
    });
};
var update_table = function(source) {
    $('#harga_1').html(numeral(source["kayu"] * 0.5).format('0,0'));
    $('#harga_2').html(numeral(source["besi"] * 0.5).format('0,0'));
    $('#harga_3').html(numeral(source["batubata"] * 0.5).format('0,0'));
    $('#harga_4').html(numeral(source["semen"] * 0.5).format('0,0'));
    $('#harga_5').html(numeral(source["tanah"] * 0.5).format('0,0'));
    $('#harga_6').html(numeral(source["plastik"] * 0.5).format('0,0'));
    $('#harga_7').html(numeral(source["kaca"] * 0.5).format('0,0'));
    $('#harga_8').html(numeral(source["air"] * 0.5).format('0,0'));
    $('#harga_9').html(numeral(source["karet"] * 0.5).format('0,0'));
    kalkulasi_ulang();
};
var kalkulasi_ulang = function() {
    var data = $(".angkaInput");
    data.each(function() {
        var id = $(this).attr('id');
        var data = id.split('_');
        var index = data[1];
        var nilai = numeral().unformat($(this).val());
        var harga = numeral().unformat($("#harga_" + index).html());
        $("#item_" + index + "_total").html(numeral(nilai * harga).format('0,0'));
    });
    checkStatusBarang();
    hitungTotalJumlah();
};
