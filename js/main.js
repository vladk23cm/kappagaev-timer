function countdown(dateEnd, el) {
	  var timer, days, hours, minutes, seconds;
	  dateEnd = parseInt(dateEnd) * 1000;
	  dateEnd = new Date(dateEnd);
	  dateEnd = dateEnd.getTime();
	  
	  if ( isNaN(dateEnd) ) {
	    return;
	  }
	  function calculate() {
		
	    var dateStart = new Date();
	    var dateStart = new Date(dateStart.getUTCFullYear(),
	                             dateStart.getUTCMonth(),
	                             dateStart.getUTCDate(),
	                             dateStart.getUTCHours(),
	                             dateStart.getUTCMinutes(),
	                             dateStart.getUTCSeconds());
	    var timeRemaining = parseInt(Math.abs((dateEnd - dateStart.getTime()) / 1000));
	 
	    if ( timeRemaining >= 0 ) {
	      days    = parseInt(timeRemaining / 86400);
	      timeRemaining   = (timeRemaining % 86400);
	      hours   = parseInt(timeRemaining / 3600);
	      timeRemaining   = (timeRemaining % 3600);
	      minutes = parseInt(timeRemaining / 60);
	      timeRemaining   = (timeRemaining % 60);
	      seconds = parseInt(timeRemaining);
	      
	      el.find(".days").html(parseInt(days, 10));
	      el.find(".hours").html(("0" + hours).slice(-2));
	      el.find(".minutes").html(("0" + minutes).slice(-2));
	      el.find(".seconds").html(("0" + seconds).slice(-2));
	    } else {
	      return;
	    }
	}
	calculate();
	timer = setInterval(function() {calculate(); }, 1000);
}

jQuery(document).ready(function($) {
	
	$('.kappagev-timer').each(function () {
		var el = $(this);
		countdown(el.attr('time'), el);
	});
})
		
