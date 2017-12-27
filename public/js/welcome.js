onload = function () {
    var e = document.getElementById("refreshed");
    if (e.value == "no") e.value = "yes";
    else {
        e.value = "no";
        location.reload();
    }
}

function hasDuplicates(array) {
    var valuesSoFar = Object.create(null);
    for (var i = 0; i < array.length; ++i) {
        var value = array[i];
        if (value in valuesSoFar) {
            return value;
        }
        valuesSoFar[value] = true;
    }
    return false;
}

function inputsHaveDuplicateValues() {
    var arr = [];
    $('.fb-box').each(function () {
        arr.push($(this).children('.fb-inner').children('.fb-input').val());
    });
    var elem = hasDuplicates(arr);
    if (!elem) {
        return false;
    }
    return elem;
}


$("#glance").unbind('click').bind("click", function (event) {
    ga('send', 'event', 'CTA', 'CTA button', 'CTA button clicked');
    fbq('trackCustom', 'CTA Clicked', '{status: "completed"}');
});
var auth = $('#auth').val();
var mainButton = $("#trigger");
$("#trigger").unbind('click').bind("click", function (event) {
    var fbBox = $('.fb-box');
    event.preventDefault();
    fbBox.removeClass('error');
    fbBox.removeClass('success');
    fbBox.removeClass('loading');

    var count = fbBox.filter(function () {
        return $(this).children('.fb-inner').children('.fb-input').val() != '';
    }).addClass('loading');
    var dupls = inputsHaveDuplicateValues();

    if (!inputsHaveDuplicateValues()) {
        mainButton.addClass('loading');
    } else {
        $('.fb-box').removeClass('loading');
        fbBox.filter(function () {
            var val = $(this).children('.fb-inner').children('.fb-input').val();
            if (val == '') {
                return false;
            }
            return dupls.includes(val);
        }).addClass('error');
        showAlert('danger', "Can't add duplicate pages", 5);
        return false;
    }

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
                    $('#f_' + index[1]).closest("div.fb-box").removeClass('success').addClass('error');
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
                showAlert('danger', 'Two Facebook pages required at least', 5);
                mainButton.removeClass('loading');
                $('.fb-box').removeClass('success');
                return false;
            }
            if (data.hasOwnProperty('pages')) {

                $.each(data.pages, function (index, value) {
                    console.log(index,value)
                    $('#f_' + index).closest("div.fb-box").removeClass('success').addClass('error');
                });
                mainButton.removeClass('loading');
                showAlert('danger', "These pages dosen't exist", 5);
                return false;
            }
            if (data.hasOwnProperty('success')) {

                ga('send', 'event', 'GeneratingFreeBenchmark', 'AddedFreeBenchmark', 'Free benchmark generating started');
                fbq('trackCustom', 'FreeBenchmark', 'Freebenchmark added');

                $.each(data.ids, function (key, value) {
                    $('<input />').attr('type', 'hidden')
                        .attr('name', "account_ids[]")
                        .attr('value', value)
                        .appendTo(form);
                });
                $.post('/create-demo', pages).done(function (data) {
                    if (auth) {
                        window.location.href = '/benchmarks/' + data;
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