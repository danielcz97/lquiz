window.addEventListener('DOMContentLoaded', () => {

  if (jQuery("body").hasClass("tests-template-default")) {

    let endTime;
    let starttime;
    if(document.querySelector('.endtime') && document.querySelector('.starttime'))
    {
      endTime = new Date(document.querySelector('.endtime').value);
      starttime = new Date(document.querySelector('.starttime').value);



    let timeNow = Date.now();
    let timeStampEnd = endTime;
    let timeStampStart = starttime.getTime();
    let countDownDate = new Date(endTime).getTime();
    let offset = endTime.getTimezoneOffset();

    let x = setInterval(function() {

      // Get today's date and time
      let now = new Date().getTime();

      // Find the distance between now and the count down date
      let distance = countDownDate - now;
      // Time calculations for days, hours, minutes and seconds
      let days = Math.floor(distance / (1000 * 60 * 60 * 24));
      let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      let seconds = Math.floor((distance % (1000 * 60)) / 1000);
      if(document.getElementById("timer")) {
        let appendTime = document.getElementById("timer");
        // Display the result in the element with id="demo"
        if (!isNaN(minutes) && !isNaN(seconds)) {
          appendTime.innerHTML = minutes + "m " + seconds + "s ";

        }
      }
      // If the count down is finished, write some text
      if (distance < 0 && document.getElementById("timer") ) {
        clearInterval(x);
        document.querySelector(".time-left").innerHTML = "KONIEC CZASU";
        document.querySelector(".form-questions").remove();
        document.querySelector(".after-submit").style.display = "block";

      }
    }, 1000);

  }
  }
});