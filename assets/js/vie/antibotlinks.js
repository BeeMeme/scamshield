$(function() {
    $('#antibotlinks_reset').hide();
    $('.antibotlinks').each(function(k){
        if (typeof(ablinks[k])!=='undefined') {
            $(this).html(ablinks[k]);
        }
    });

    $('.antibotlinks a').click(function() {
        $('#antibotlinks_reset').show();
        $('#antibotlinks').val($('#antibotlinks').val()+' '+$(this).attr('rel'));
        $(this).hide();
        return false;
    });

    $('#antibotlinks_reset').click(function() {
        $('#antibotlinks').val('');
        $('.antibotlinks a').show();
        $('#antibotlinks_reset').hide();
        return false;
    });
});