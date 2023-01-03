$("#token").keypress(() => {
  setTimeout(() => {
    let usd = parseFloat($("#token").val()) * rate;
    $("#usd").val(usd);
    $("input[name=amount1]").val(usd);
  }, 50);
});
$("#usd").keypress(() => {
  setTimeout(() => {
    let token = parseFloat($("#usd").val()) / rate;
    $("#token").val(token.toFixed(3));
    $("input[name=amount1]").val($("#usd").val());
  }, 50);
});
function formUpdate() {
  $("#depForm").attr("action", methods[$("#method").val()].url);
  $("#usd").attr("min", methods[$("#method").val()].min);
  $("#minDep").text(
    `Minimum deposit is ${methods[$("#method").val()].min} USD`
  );
  if ($("#method").val() === "faucetpay") {
    $("#fpCurrency").css("display", "block");
  } else {
    $("#fpCurrency").css("display", "none");
  }
}
$("#method").change(function () {
  formUpdate();
});
formUpdate();
