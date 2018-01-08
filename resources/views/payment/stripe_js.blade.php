 <script type="text/javascript">
var since = new Date();
since.setDate(since.getDate() - 2);
var until = new Date();
until.setDate(until.getDate() - 1);
$( document ).ready(function() {

	$('.stripe-button-el').css('display','none');
	var input_from = $('#date-from').pickadate({
			showMonthsShort: true,
		 	close: 'Cancel',
		 	labelMonthNext: 'Go to the next month',
	  		labelMonthPrev: 'Go to the previous month',
	  		format: 'yyyy-mm-dd',
	  		max: since,
	});
	var input_to = $('#date-to').pickadate({
			showMonthsShort: true,
		 	close: 'Cancel',
		 	labelMonthNext: 'Go to the next month',
	  		labelMonthPrev: 'Go to the previous month',
	  		format: 'yyyy-mm-dd',
	  		max: until,
	});
	input_from = input_from.pickadate('picker');
	input_to = input_to.pickadate('picker');

	input_from.set('select', Orisince);
	input_to.set('select', Oriuntil);

	input_from.on({
	  set: function(e) {
	   if(e.select){
	   	$('#since').val($('#date-from').val() );
	   	valideDates();
	   }
	  }
	});
	input_to.on({
	  set: function(e) {
	   if(e.select){
	   	$('#until').val($('#date-to').val() );
	   	valideDates();
	   }
	  }
	});

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
$('#title').focus(function(e){
	$('.print-btn').attr('disabled',true);
});
$('#title').focusout(throttle(function(e){
	$('.print-btn').attr('disabled',true);
	var original = $('#original').val();
	if(original === $(this).val()){
		$('.print-btn').attr('disabled',false);
		return false;
	}
	var inputVal = document.getElementById("title");
	var newVal = $(this).val();
	if($(this).val().length < 5){
		showAlert('danger','Title is too short',5);
    	inputVal.style.borderColor = '#ED1C24';
    	return false;
	} else {
    	inputVal.style.borderColor = '#ECEBEB';
    }
	$.post( "/api/benchmarks/update-title", { title: $(this).val() ,id : {!! json_encode($benchmark->details->id) !!} })
	.done(function( data ) {
		$('.print-btn').attr('disabled',false);
		$('#benchTitle').text(newVal);
		ga('send', 'event', 'BenchmarkPage', 'UpdateTitle', 'Updated benchmark title');
        fbq('trackCustom', 'BenchmarkTitle','{status: "Updated title"');
    	if(data.msg == 'error'){
    		inputVal.style.borderColor = '#ED1C24';
    	} else {
    		inputVal.style.borderColor = '#ECEBEB';
    	}
  	});
}));
function valideDates(){
	$('#hideme').attr('disabled',true);
	$('.price').html('0 USD');
	$('#difTime').html('<span>Benchmark 7 Days</span>');
	if($('#date-from').val() == '' || $('#date-to').val() == ''){
		showAlert('danger','Invalid date range',6);
		return false;
	}
	var since = new Date($('#date-from').val());
	var until = new Date($('#date-to').val());
	if(until < since){
		showAlert('danger','Invalid date range',6);
		return false;
	}
	if(timeDiff(since,until) < 8){
		showAlert('danger','Date range must be more than 7 days',6);
		return false;
	}
	var diff = timeDiff( $('#date-from').val(), $('#date-to').val() );
	$('#difTime').html('<span>Benchmark '+diff+' Days</span>');
	$('.price').html('5 USD');
	$('#hideme').attr('disabled',false);
	return true;
}

</script>
