const countDown = setInterval(() => {
  if (typeof wait !== 'undefined') {
    if (wait == 0) {
      clearInterval(countDown);
      location.href = "";
    }
    let minutes = Math.floor(wait / 60);
    let seconds = wait % 60;
    $("#minute").text(minutes);
    $("#second").text(seconds);
    wait -= 1;
  }
}, 1000);

$(document).ready(function () {
  let timer = 6;
  const counter = setInterval(() => {
    if (timer == 0) {
      $(".claim-button").html(
        '<i class="far fa-check-circle"></i> Collect your reward'
      );
      $(".claim-button").removeAttr("disabled");
      clearInterval(counter);
    } else {
      if (timer === 1) {
        $(".claim-button").text(`Please wait ${timer} second`);
      } else {
        $(".claim-button").text(`Please wait ${timer} seconds`);
      }
      --timer;
    }
  }, 1000);
});
