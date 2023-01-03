var el = document.getElementById("rollNumber");
var od = new Odometer({
  el: el,
  auto: false,
  format: "(dd).dd",
});
window.odometerOptions = {};
(function ($) {
  "use strict";
  let firstGame = true;
  function updateGame() {
    setTimeout(() => {
      const multi = $("#multiplier").val();
      const multi2 = 100 / multi;
      const multi3 = multi2 - 0.02;
      const betAmount = $("#betAmount").val();
      const grossProfit = multi3 * betAmount;
      const profit2 = grossProfit - betAmount;
      $("#profit").val(profit2.toFixed(6));
    }, 50);
  }

  function updateMultiplier() {
    const mulmultiplier = $("#multiplier").val();
    $("#rollLo").html(`Roll under ${mulmultiplier}`);
    $("#rollHi").html(`Roll over ${100 - mulmultiplier}`);
  }

  $("#double").click(function () {
    const betAmount = $("#betAmount").val();
    if (betAmount !== "") {
      const newAmount = 2 * parseFloat(betAmount);
      $("#betAmount").val(newAmount.toFixed(6));
      updateGame();
    }
  });

  $("#half").click(function () {
    const betAmount = $("#betAmount").val();
    if (betAmount !== "") {
      const newAmount = 0.5 * parseFloat(betAmount);
      $("#betAmount").val(newAmount.toFixed(6));
      updateGame();
    }
  });

  $("#betAmount").keydown(function () {
    setTimeout(() => {
      updateGame();
    }, 50);
  });

  $("#betAmount").keyup(function () {
    updateGame();
  });

  $("#betAmount").change(function () {
    updateGame();
  });

  $("#multiplier").keydown(function () {
    updateMultiplier();
    updateGame();
  });

  $("#multiplier").keyup(function () {
    updateMultiplier();
    updateGame();
  });

  $("#multiplier").change(function () {
    updateMultiplier();
    updateGame();
  });

  function alertDice() {}

  $("#rollHi").click(function () {
    rollDice("rollHi");
  });
  $("#rollLo").click(function () {
    rollDice("rollLo");
  });

  function rollDice(rollType) {
    $("#diceHistory").html();
    $("#rollHi").attr("disabled", "disabled");
    $("#rollLo").attr("disabled", "disabled");
    const multiplier = $("#multiplier").val();
    const betAmount = $("#betAmount").val();
    $.post(
      site_url + "dice/roll",
      {
        betAmount,
        multiplier,
        rollType,
      },
      function (data, status) {
        $("#rollHi").removeAttr("disabled");
        $("#rollLo").removeAttr("disabled");
        const result = JSON.parse(data);
        if (result.status === "success") {
          $("#hashRoll").text(result.proof);

          const alertType = result.type === "win" ? "success" : "danger";
          $("#result").html(
            `<div class="alert text-center alert-${alertType}">${result.message}</div>`
          );

          const diceHistory = $("#diceHistory").html();
          const recentHistory = result.recent;
          const recentDice = `<tr><th scope="row">${recentHistory.id}</th><td>${recentHistory.secret}</td><td>${recentHistory.target}</td><td>${recentHistory.bet}</td><td>${recentHistory.roll}</td><td>${recentHistory.profit}</td></tr>`;
          $("#diceHistory").html(recentDice + diceHistory);
          od.update(recentHistory.roll);
        } else {
          $("#result").html(
            `<div class="alert text-center alert-danger">${result.message}</div>`
          );
        }
      }
    );
  }

  updateMultiplier();
  updateGame();
})(jQuery);
