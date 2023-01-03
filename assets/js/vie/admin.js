$(".fraudcontent").click(function () {
  const content = $(this).attr("fraudcontent");
  $(`.check-${content}`).prop("checked", true);
});
$(".suspect-button").click(function (e) {
  const to = $(this).attr("submitto");
  $("#submit-form").attr("action", to);
});
