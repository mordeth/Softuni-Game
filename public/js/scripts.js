$(document).ready(function() {
	$('.castle-building-panel').each(function() {
      var selector = $(this).data('tooltip-id');
      Tipped.create(this, $(selector)[0]);
    });
});