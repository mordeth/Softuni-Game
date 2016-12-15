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
		}, 2000);
	  });
	});
	$('.requirements .wood, .requirements .stone').each(function() {
		var needed = parseInt($(this).find('.needed').text()),
			available = parseInt($(this).find('.available').text())
		;

		if(needed > available) {
			$(this).find('.available').css('color', '#FF0000');
			$(this).closest('.requirements').siblings('.panel-button').hide();
		}
	});
});