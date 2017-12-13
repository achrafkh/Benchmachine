$(document).ready(function() {
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

	$('#table').bootstrapTable({
		onSort: function (col, type) {
		    $('#type').val(type);
	  		$('#col').val(col);
	    }
	});

	
	// $('#table').DataTable({
	// 	"paging":   false,
 //        "ordering": true,
 //        "info":     false,
 //        "bFilter": false,
 //        columnDefs: [
 //          { targets: 'no-sort', orderable: false }
 //        ]
 //    });
	// var order = null;
	// $('#table').on('order.dt', function () {
	// 	order = $('#table').dataTable().fnSettings().aaSorting;
	// });
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

function startLoader()
{
	document.body.classList.add("loading");
}

function removeLoader()
{
	document.body.classList.remove("loading");
}

