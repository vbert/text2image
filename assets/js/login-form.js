/**
 * @author Wojciech Sobczak, wsobczak@gmail.com
 * @copyright (c) 2017
 */
$(window, document, undefined).ready(function() {

	function refresh_inputs() {
		$('input').each(function() {
			var $this = $(this);
			if ($this.val()) {
				$this.addClass('used');
			} else {
				$this.removeClass('used');
			}
		});
	}

	$('input').blur(function() {
		refresh_inputs();
	});

	$('input').change(function() {
		refresh_inputs();
	});

	var $ripples = $('.ripples');

	$ripples.on('click.Ripples', function(e) {
		var $this = $(this);
		var $offset = $this.parent().offset();
		var $circle = $this.find('.ripplesCircle');

		var x = e.pageX - $offset.left;
		var y = e.pageY - $offset.top;

		$circle.css({
			top: y + 'px',
			left: x + 'px'
		});

		$this.addClass('is-active');
	});

	$ripples.on('animationend webkitAnimationEnd mozAnimationEnd oanimationend MSAnimationEnd', function(e) {
		$(this).removeClass('is-active');
	});
});
