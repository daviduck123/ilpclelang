$(document).ready(function() {
    $(".numberonly").keypress(function(e) {
        if ((e.charCode >= 48 && e.charCode <= 57) || (e.charCode == 0))
            return true;
        else
            return false;
    });
    $(".nominal").keypress(function(e) {
        if (e.charCode >= 48 && e.charCode <= 57) {
            var string = numeral().unformat($(this).val());
            if (string === '0')
                $(this).val('');
            else
                $(this).val(string);
        }
    });
    $(".nominal").keyup(function(e) {
        var string = numeral($(this).val()).format('0,0');
        $(this).val(string);
    });

});
