jQuery.fn.load = function(callback){ $(window).on("load", callback) };

function elementInViewport(el) {
  var top = el.offsetTop;
  var left = el.offsetLeft;
  var width = el.offsetWidth;
  var height = el.offsetHeight;

  while(el.offsetParent) {
    el = el.offsetParent;
    top += el.offsetTop;
    left += el.offsetLeft;
  }

  return (
    top < (window.pageYOffset + window.innerHeight) &&
    left < (window.pageXOffset + window.innerWidth) &&
    (top + height) > window.pageYOffset &&
    (left + width) > window.pageXOffset
  );
}
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function showAlert(type, text, duration){

	var alert = '\
		<div class="alert alert-' + type + ' alert-dismissible fade in">\
		    <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="icon-cancel"></i></a>\
		    ' + text + '\
		</div>\
	'
	if(duration != undefined || duration > 0){
		$(alert).fadeIn(300).delay(duration * 1000).fadeOut(300, function(){$(this).remove()}).appendTo('.alerts-container');
	}else{
		$(alert).fadeIn(300).appendTo('.alerts-container');
	}
}

$(document).ready(function() {


	/*
	-----------------------------------------
	Tooltip
	-----------------------------------------
	*/

	$('[data-toggle="tooltip"]').tooltip();

	/*
	-----------------------------------------
	Svg polyfill
	-----------------------------------------
	*/

	svg4everybody({
		polyfill: true,
	});

	/*
	-----------------------------------------
	Triggers
	-----------------------------------------
	*/

	$('.sidebar-trigger').on('click', function(){
		if(!$('.sidebar').hasClass('active')){
			$('body').addClass('no-scroll');
			$('.sidebar, .sidebar-backlayer').addClass('active');
		}
	})
	$('.sidebar-close, .sidebar-backlayer').on('click', function(){
		if($('.sidebar').hasClass('active')){
			$('body').removeClass('no-scroll');
			$('.sidebar, .sidebar-backlayer').removeClass('active');
		}
	})


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
	Datatables Table
	-----------------------------------------
	*/

	$('#table').DataTable({
		paging:   false,
		ordering: true,
		info:     false,
		searching: false,
		scrollX: true,
	});


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
			$('.fb-form-inner').append(
				'<div class="media fb-box">\
					<div class="media-left fb-icon">\
						<i class="icon-facebook"></i>\
						<i class="icon-ok"></i>\
						<i class="icon-cancel"></i>\
						<i class="icon-spin5 animate-spin"></i>\
					</div>\
					<div id="f_'+(index +1)+'" class="media-body fb-inner error_c">\
						<label for="fb_page_'+ (index +1) +'" class="fb-nb">'+ nb[index+1] +' page</label>\
						<input id="fb_page_'+ (index +1) +'" class="fb-input" type="text" name="accounts[]" placeholder="https://www.facebook.com/exemple">\
					</div>\
				</div>'
			)
			index++
		}
	});
});
function timeDiff(v1,v2)
{
	var date1 = new Date(v1);
	var date2 = new Date(v2);
	var timeDiff = Math.abs(date2.getTime() - date1.getTime());
	return diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
}

Date.prototype.format = function(format) //author: meizz
{
  var o = {
    "M+" : this.getMonth()+1, //month
    "d+" : this.getDate(),    //day
    "h+" : this.getHours(),   //hour
    "m+" : this.getMinutes(), //minute
    "s+" : this.getSeconds(), //second
    "q+" : Math.floor((this.getMonth()+3)/3),  //quarter
    "S" : this.getMilliseconds() //millisecond
  }

  if(/(y+)/.test(format)) format=format.replace(RegExp.$1,
    (this.getFullYear()+"").substr(4 - RegExp.$1.length));
  for(var k in o)if(new RegExp("("+ k +")").test(format))
    format = format.replace(RegExp.$1,
      RegExp.$1.length==1 ? o[k] :
        ("00"+ o[k]).substr((""+ o[k]).length));
  return format;
}
$.fn.isOnScreen = function(){
        var win = $(window);
        var viewport = {
            top : win.scrollTop(),
            left : win.scrollLeft()
        };
        viewport.right = viewport.left + win.width();
        viewport.bottom = viewport.top + win.height();

        var bounds = this.offset();
        bounds.right = bounds.left + this.outerWidth();
        bounds.bottom = bounds.top + this.outerHeight();
        viewport.bottom = viewport.bottom * 0.88;

        return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
    };
window.smoothScroll = function(target) {
    var scrollContainer = target;
    do { //find scroll container
        scrollContainer = scrollContainer.parentNode;
        if (!scrollContainer) return;
        scrollContainer.scrollTop += 1;
    } while (scrollContainer.scrollTop == 0);

    var targetY = 0;
    do { //find the top of target relatively to the container
        if (target == scrollContainer) break;
        targetY += target.offsetTop;
    } while (target = target.offsetParent);

    scroll = function(c, a, b, i) {
        i++; if (i > 30) return;
        c.scrollTop = a + (b - a) / 30 * i;
        setTimeout(function(){ scroll(c, a, b, i); }, 20);
    }
    // start scrolling
    scroll(scrollContainer, scrollContainer.scrollTop, targetY, 0);
}

$( ".track_click" ).click(function() {
  ga('send', 'event', $(this).data('section'), $(this).data('name'), $(this).data('desc'));
  fbq('trackCustom', $(this).data('name'),$(this).data('fbq'));
});


