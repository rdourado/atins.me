(($)->
	$('body').removeClass('no-js')
	$('.list','.hero')
		.on 'init', (event, slick) ->
			slick.$slider.addClass 'on'
			slick.$slides.each (i, el) ->
				slide = $ el
				slide.attr 'style', slide.data('style')
		.slick({
			dots: true
			autoplay: true
			autoplaySpeed: 5000
			pauseOnHover: true
		})
	$('a','.gallery-item').attr('rel', 'directory').fancybox({type:'image'})
	$('a[href*=".png"], a[href*=".gif"], a[href*=".jpg"], a.fancy, a.fancybox').fancybox()
	$('img.lazy').lazyload()
	# $(window).load ->
	# 	if tripadvisor?
	# 		$('#trip-wrap').html($.parseJSON(tripadvisor))
	$('.sub-menu').each (index, item) ->
		sub = $(this)
		$(this).prev().on 'click', (event) ->
			do event.preventDefault if $(document).width() <= 880
			sub.toggleClass 'show'
	return
) jQuery