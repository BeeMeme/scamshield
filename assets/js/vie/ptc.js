$(document).ready(function () {
  --timer;
  const count = setInterval(() => {
    if (timer < 0) {
      $("#ptcCaptcha").modal("show");
      clearInterval(count);
    } else {
      if (timer > 1) {
        $("#ptcCountdown").text(`${timer} seconds`);
      } else {
        $("#ptcCountdown").text(`${timer} second`);
      }
      if (document.hasFocus()) --timer;
    }
  }, 1000);
});

$("#verify").click(() => {
  let win = window.open(url, "_blank");
  win.focus();
});
