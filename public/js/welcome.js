onload=function(){
    var e=document.getElementById("refreshed");
    if(e.value=="no")e.value="yes";
    else{e.value="no";location.reload();}
}

$("#glance").unbind('click').bind("click", function (event) {
    ga('send', 'event', 'CTA', 'CTA button', 'CTA button clicked');
    fbq('trackCustom', 'CTA Clicked','{status: "completed"}');
});
var auth = $('#auth').val();
console.log(auth);
var mainButton = $("#trigger");
        $("#trigger").unbind('click').bind("click", function (event) {

        mainButton.addClass('loading');
        $('.fb-box').removeClass('error');
        $('.fb-box').removeClass('success');
        $('.fb-box').removeClass('loading');

        $('.fb-box').addClass('loading');


        $('#min').css('display', 'none');

        event.preventDefault();
        var form = $('#submit_pages');
        var pages = $('#submit_pages').serializeArray();
        $.ajax({
            url: '/api/pages/validate',
            type: 'post',
            statusCode: {
                422: function (response) {
                    $('.fb-box').removeClass('loading');
                    $('.fb-box').addClass('success');
                    $.each(response.responseJSON.errors, function (key, value) {
                        var index = key.split(".");
                        $('#f_' + index[1]).closest( "div.fb-box" ).removeClass('success').addClass('error');
                    });
                    $('.fb-box').last().removeClass('error').removeClass('success').removeClass('loading');
                    mainButton.removeClass('loading');
                }
            },
            data: pages,
            success: function (data) {
                $('.fb-box').removeClass('loading');
                $('.fb-box').addClass('success');
                $('.fb-box').last().removeClass('error').removeClass('success').removeClass('loading');

                if (data.hasOwnProperty('min')) {

                    $('#min').css('display', 'block');
                    mainButton.removeClass('loading');
                    return false;
                }
                if (data.hasOwnProperty('pages')) {

                    $.each(data.pages, function (index, value) {
                        $('#f_' + index).closest( "div.fb-box" ).removeClass('success').addClass('error');
                    });
                    mainButton.removeClass('loading');
                    return false;
                }
                if (data.hasOwnProperty('success')) {

                    ga('send', 'event', 'GeneratingFreeBenchmark', 'AddedFreeBenchmark', 'Free benchmark generating started');
                    fbq('trackCustom', 'FreeBenchmark','Freebenchmark added');

                         $.each(data.ids, function (key, value) {
                            $('<input />').attr('type', 'hidden')
                                    .attr('name', "account_ids[]")
                                        .attr('value', value)
                                        .appendTo(form);
                            });
                           $.post( '/create-demo', pages ).done(function( data ) {
                                if(auth){
                                    window.location.href = '/benchmarks/'+data;
                                    return false;

                                } else {
                                     window.location.href = '/auth/facebook';
                                }
                            });
                            event.preventDefault();
                        }
                    },
                    error: function (data) {
                        console.log(data.responseJSON)
                    }
                });
            });