jQuery(document).ready(function ($) {
  $("#double").click(function () {
    const betAmount = $("#betAmount").val();
    if (betAmount !== "") {
      const newAmount = 2 * parseFloat(betAmount);
      $("#betAmount").val(newAmount.toFixed(6));
    }
  });

  $("#half").click(function () {
    const betAmount = $("#betAmount").val();
    if (betAmount !== "") {
      const newAmount = 0.5 * parseFloat(betAmount);
      $("#betAmount").val(newAmount.toFixed(6));
    }
  });
  function coinFlip(flipResult) {
    $("#coinflip").removeClass();
    setTimeout(function () {
      if (flipResult === "BTC") {
        $("#coinflip").addClass("heads");
      } else {
        $("#coinflip").addClass("tails");
      }
    }, 100);
  }
  $(".bet-btn").on("click", function () {
    $("#betBTC").attr("disabled", "disabled");
    $("#betETH").attr("disabled", "disabled");
    const betAmount = $("#betAmount").val();
    const coin = $(this).attr("data-coin");
    $.post(
      site_url + "coinflip/flip",
      {
        betAmount,
        coin,
      },
      function (data, status) {
        $("#betBTC").removeAttr("disabled");
        $("#betETH").removeAttr("disabled");
        const result = JSON.parse(data);
        coinFlip(result.result);
        if (result.status !== "false") {
          const alertType = result.status === "success" ? "success" : "danger";
          $("#result").html(
            `<div class="alert text-center alert-${alertType}">${result.message}</div>`
          );

          const coinflipHistory = $("#coinflipHistory").html();
          const recentDice = `<tr><th scope="row">${result.id}</th><td>${result.betAmount}</td><td>${result.coin}</td><td>${result.result}</td><td>${result.profit}</td></tr>`;
          $("#coinflipHistory").html(recentDice + coinflipHistory);
        } else {
          $("#result").html(
            `<div class="alert text-center alert-danger">${result.message}</div>`
          );
        }
      }
    );
  });
});
