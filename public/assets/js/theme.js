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
					<div id="f_'+(index +1)+'" class="media-body fb-inner error_c">\
						<h4 class="fb-nb">'+ nb[index+1] +' page</h4>\
						<input id="fb_page_'+ (index +1) +'" class="fb-input" type="text" name="accounts[]" placeholder="https://www.facebook.com/exemple">\
					</div>\
				</div>'
			)
			index++
		}
	});

$("#trigger").unbind('click').bind("click", function (event) {
    $('#min').css('display','none');
    $('.error_c').css('border-style', 'none');
    event.preventDefault();
    var form = $('#submit_pages');
    var pages = $('#submit_pages').serializeArray();
    $.ajax({
        url: '/api/pages/validate',
        type: 'post',
        statusCode: {
            422: function (response) {
                $.each(response.responseJSON.errors, function (key, value) {
                    var index = key.split(".");
                    $('#f_'+index[1]).css('border-color', '#ffc1c1').css('border-style', 'solid');
                });
            }
        },
        data: pages,
        success: function (data) {
        	console.log(data)
            if (data.hasOwnProperty('min')) {
              $('#min').css('display','block');
              return false;
            }
            if (data.hasOwnProperty('pages')) {
                $.each(data.pages, function( index, value ) {
             		$('#f_'+index).css('border-color', '#ffc1c1').css('border-style', 'solid');
                });
            return false;
            }
            if (data.hasOwnProperty('email')) {
              $('#email').css('border-color', '#ffc1c1').css('border-style', 'solid');
              return false;
            }
			if (data.hasOwnProperty('success')) {
				$.each(data.ids, function (key, value) {
					console.log(value);
					$('<input />').attr('type', 'hidden')
						.attr('name', "account_ids[]")
						.attr('value', value)
						.appendTo(form);
				});
				form.submit();
			}
        },
        error: function (data) {
            console.log(data.responseJSON)
        }
    });
});




});