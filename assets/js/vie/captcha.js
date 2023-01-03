$(document).ready(function () {
    var curr = $('#selectCaptcha').val();
    $(`#${curr}`).css('display', 'block');
});
$('#selectCaptcha').change(function () {
    $('.captcha').css('display', 'none');
    var curr = $(this).val();
    $(`#${curr}`).css('display', 'block');
});