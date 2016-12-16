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
	$('.unit-control a').each(function() {
		var $this = $(this),
			units = parseInt($(this).text()),
			foodNeeded = parseInt($this.closest('.add-unit').find('.required.food').text()),
			goldNeeded = parseInt($this.closest('.add-unit').find('.required.gold').text()),
			totalFood = parseInt($('.nav .food').text()),
			totalGold = parseInt($('.nav .gold').text())
		;
		
		if((units * foodNeeded) > totalFood) {
			$this.attr('href', '');
			$this.addClass('not-enough-resources');
		}
		
		if((units * goldNeeded) > totalGold) {
			$this.attr('href', '');
			$this.addClass('not-enough-resources');
		}
		
	});
	$(".lightbox").fancybox({
		maxWidth	: 800,
		maxHeight	: 600,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
	$(".not-enough-level").each(function() {
		var level = $(this).data('level');
		$(this).prepend('<div class="army-overlay">Required Fortress '+ level +' level</p>');
	});
});