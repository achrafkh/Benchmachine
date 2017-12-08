<script type="text/javascript">
var since = new Date();
since.setDate(since.getDate() - 2);
var until = new Date();
until.setDate(until.getDate() - 1);

$( document ).ready(function() {
	$( ".animateMe" ).each(function( index ) {
		var nbr = parseInt( $(this).text().replace(/ /g,'') , 10);
		$(this).text(0);
		 setTimeout(function() {
	        $(this).animateNumber({
	         number: nbr,
	         easing: 'easeInQuad',
	        },2000);
	    }.bind(this), 1500 + (index * 100));
	});

    $('#datepicker-inline-until').datepicker({
	    todayHighlight: false,
	    inline: true,
	    endDate: until,
        useCurrent: false,
	    format: 'yyyy-mm-dd',
    }).on('changeDate', function(event){
    	$('#until').val($('#datepicker-inline-until').datepicker("getFormattedDate"));

    	valideDates();
    });
	$('#datepicker-inline-since').datepicker({
	    todayHighlight: false,
	    inline: true,
	    endDate: since,
        useCurrent: false,
	    format: 'yyyy-mm-dd'
    }).on('changeDate', function(event){
    	$('#since').val($('#datepicker-inline-since').datepicker("getFormattedDate"));
    	valideDates();
    });
});
function throttle(f, delay){
var timer = null;
	return function(){
	    var context = this, args = arguments;
	    clearTimeout(timer);
	    timer = window.setTimeout(function(){
	        f.apply(context, args);
	    },
	    delay || 1200);
	};
}
$('#title').focusout(throttle(function(e){
	var original = $('#original').val();
	if(original === $(this).val()){
		return false;
	}
	var inputVal = document.getElementById("title");
	if($(this).val().length < 5){

    	inputVal.style.borderColor = '#ED1C24';
    	return false;
	} else {
    	inputVal.style.borderColor = '#ECEBEB';
    }
	$.post( "/api/benchmarks/update-title", { title: $(this).val() ,id : {!! json_encode($benchmark->details->id) !!} })
	.done(function( data ) {
    	if(data.msg == 'error'){
    		inputVal.style.borderColor = '#ED1C24';
    	} else {
    		inputVal.style.borderColor = '#ECEBEB';
    	}
  	});
}));


function valideDates(){
	$('#hideme').css('display','none');
	$('.price').html('0 USD');
	$('#difTime').html('<span>Benchmark 7 Days</span>');
	if($('#since').val() == '' || $('#until').val() == ''){
		return false;
	}
	var since = new Date($('#since').val());
	var until = new Date($('#until').val());
	if(until < since){
		return false;
	}
	if(timeDiff(since,until) < 8){
		return false;
	}
	var diff = timeDiff( $('#since').val(), $('#until').val() );
	$('#difTime').html('<span>Benchmark '+diff+' Days</span>');
	$('.price').html('5 USD');
	$('#hideme').css('display','block');
	return true;
}

</script>
