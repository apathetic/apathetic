// --------------------------
// apathetic
// --------------------------

(function( wes, $, undefined ) {

    // ------------ private ------------
	function setupFilters() {
		// var container = $('#main .block');		// <--neat effect !
		var container = $('.blocks');
		if (! container.length) { return; }

		container.isotope({ itemSelector:'.block' });

		var filters = $('#filter ul a');
		filters.click(function(e){
			filters.removeClass('selected');
			var selector = $(this).addClass('selected').data('filter');
			container.isotope({ filter: selector });
			return false;
		});

		$(window).smartresize(function(){
			container.isotope( 'reLayout' );
		});

	}



    // ------------ public ------------
	wes.hatch = function() {

		setupFilters();
		// $('.carousel').carousel({	});
		$('.carousel').scrubbable();
		$('img.lazy').lazyload();

	};

}( window.wes = window.wes || {}, jQuery ));



// --------------------------
// plugins
// --------------------------

(function($){
	$.fn.carousel = function(o) {
		o = $.extend({
			prev: null,
			next: null,
			jump: null,
			speed: 200,
			easing: null,
			callback: null,
			start: 0,
			width: false	// manually override width
		},
		o || {});
		return this.each(function() {
			var b = false,		// animating
			c = $(this),
			ul = $('ul', c),
			f = $('li', ul),
			next = o.next ? $(o.next) : $('.next', c),
			prev = o.prev ? $(o.prev) : $('.prev', c),
			pages = f.length,
			curr = o.start;

			f.css('float','left');
			ul.css({'position': 'relative'});
			c.css({
				'visibility': 'visible',
				'overflow': 'hidden',
				'position': 'relative',
			});
			var g = o.width ? o.width : f.outerWidth(true); 	// f.get(0).offsetWidth;
			var h = g * pages;

			ul.css('width', h +'px').css('left', -(curr * g));

			if (prev.length > 0) prev.click(function() {
				return go(curr - 1);
			});
			if (next.length > 0) next.click(function() {
				return go(curr + 1);
			});
			if (o.jump) $.each(o.jump, function(i, a) {
				$(a).click(function() {
					return go(i);
				});
			});

			function go(a) {
				if (!b) {

					if (a < 0 || a > pages - 1) return;
					else curr = a;

					b = true;
					ul.animate({left: -(curr * g)}, o.speed, o.easing, function() {
						b = false;
						if (o.callback) { o.callback.call(this, curr, f.slice(curr).slice(0,1) ); }
					});

					next.removeClass('disabled');
					prev.removeClass('disabled');
					$((curr - 1 < 0 && prev) || (curr + 1 > pages - 1 && next) || []).addClass('disabled');

				}
				return false;
			}
		});
	}

	$.fn.scrubbable = function(o) {
		o = $.extend({
			reset: false,
			element: 'img'
		},
		o || {});
				
		return this.each(function(){
			// var h = $(this).find(o.element).first().attr('height'),
			// 	w = $(this).find(o.element).first().attr('width');
			// $(this).css({'height':h, 'width':w});


			var items = $(this).find(o.element).css({'position':'absolute', 'left':0, 'top':0});

			$(this)
				.css({'position': 'relative'})
				.mousemove(function(e) {
					var $this = $(this),
						offset = Math.floor( (e.pageX-$this.offset().left) / ($this.width()/items.length) );
					// items.addClass('hidden').eq(offset).removeClass('hidden');
					items.css('display','none').eq(offset).css('display','block');
				})
				.mouseleave(function(e) {
					if (o.reset) {
						// items.addClass('hidden').eq(0).removeClass('hidden');
						items.css('display','none').eq(0).css('display','block');
					}
				})
				.end();
		});
	};
})(jQuery);



// --------------------------
// blitz. engage. smash.
// --------------------------

jQuery( wes.hatch );
