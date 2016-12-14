$(document).ready(function() {
	$('.castle-building-panel').each(function() {
      var selector = $(this).data('tooltip-id');
      Tipped.create(this, $(selector)[0]);
    });
	
	$('[data-countdown]').each(function() {
	  var $this = $(this), finalDate = $(this).data('countdown');
	  $this.countdown(finalDate, function(event) {
		$this.html(event.strftime('%H:%M:%S'));
	  }).on('finish.countdown', function() {
		setTimeout( function() {
			location.reload();
		}, 500);
	  });
	});
});