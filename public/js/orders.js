$( function () {
    $ ( document )
        .ready( function () {
            $.ajax( {
                url: baseUrl+'/orders/get-orders',
                type: 'GET',
                dataType: 'html',
                data: {},
                success: function( res ) {
                    $('.orders_list').html( res )
                }
            } )
        } )
} )