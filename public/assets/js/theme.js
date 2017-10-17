$(document).ready(function() {

	/*
	-----------------------------------------
	Tooltip
	-----------------------------------------
	*/

	$('[data-toggle="tooltip"]').tooltip();

	/*
	-----------------------------------------
	Waves
	-----------------------------------------
	*/

	$.ripple('[waves-hover]', {
		on: 'mouseenter',
		multi: true
	});

	$.ripple('[waves-hover]', {
		multi: true
	});

	$.ripple('[waves-click]', {
		multi: true
	});

	/*
	-----------------------------------------
	Bootstrap Table
	-----------------------------------------
	*/

	$('#table').bootstrapTable();

	/*
	-----------------------------------------
	Focus
	-----------------------------------------
	*/

	var index = 1;
	var nb = ['First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth'];

	$(document).on('focus', '.fb-input', function(){
		var parent = $(this).parents('.fb-box');
		$('.fb-box').removeClass('focused');
		parent.addClass('focused');
		if(parent.index() == index && index < 9){
			$('.fb-wrap').append(
				'<div class="media fb-box">\
					<div class="media-left fb-icon">\
						<i class="icon-facebook"></i>\
					</div>\
					<div class="media-body fb-inner">\
						<h4 class="fb-nb">'+ nb[index] +' page</h4>\
						<input id="fb_page_'+ (index +1) +'" class="fb-input" type="text" name="accounts[]" placeholder="https://www.facebook.com/exemple">\
					</div>\
				</div>'
			)
			index++
		}
	})
});