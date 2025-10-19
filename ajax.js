
function show_all_invest(invest) {

    var currentRequest = null;

    jQuery.ajax({
        url: ajax_object.ajaxurl,
        type: 'GET',
        data: {
            action: 'show_all_invest',
            invest: invest,
            ajax: 'true'
        },
        dataType: 'html',

        beforeSend: function() {

            if(currentRequest != null) {
                currentRequest.abort();
            }

            $('#results').html('');
            $('.se-ajax-loader').fadeIn();
        },

        complete: function(){
            $('.se-ajax-loader').fadeOut();
            $('.count-info').addClass('show');
        },

        success: function (data) {

            var dataResponse = JSON.parse(data);

            if( dataResponse['render'].length > 0 ) {            
                jQuery.each( dataResponse.render, function( i, val ) {
                    $('#results').append(val);
                });
            }

            $('#found').append(dataResponse['count']);
            $('#all').append(dataResponse['count']);

            if(dataResponse['render'][0].length == 0) {
                $('#results').append('<div class="nothing-found">Brak mieszkań</div>');
            }
        },

        error: function(errorThrown){

        }
    });
};

function search_invest(invest) {

    var currentRequest = null;
    var status = $('#status').val();
    var rooms = $('#rooms').val();
    var amount = $('#amount').val();
    var price = $('#price').val();

    jQuery.ajax({
        url: ajax_object.ajaxurl,
        type: 'GET',
        data: {
            action: 'search_invest',
            invest: invest,
            status: status,
            rooms: rooms,
            amount: amount,
            price: price,
            ajax: 'true'
        },
        dataType: 'html',

        beforeSend: function() {

            if(currentRequest != null) {
                currentRequest.abort();
            }

            $('#results').html('');
            $('.se-ajax-loader').fadeIn();
        },

        complete: function(){
            $('.se-ajax-loader').fadeOut();
            $('.count-info').addClass('show');
        },

        success: function (data) {

            var dataResponse = JSON.parse(data);

            if( dataResponse['render'].length > 0 ) {            
                jQuery.each( dataResponse.render, function( i, val ) {
                    $('#results').append(val);
                });
            }

            $('#found').html('');
            $('#all').html('');
            $('#found').append(dataResponse['count']);
            $('#all').append(dataResponse['all']);

            if(dataResponse['render'][0].length == 0) {
                $('#results').append('<div class="nothing-found">Brak mieszkań</div>');
            }
        },

        error: function(errorThrown){

        }
    });
};