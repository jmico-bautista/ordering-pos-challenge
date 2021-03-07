$( function () {
    $( document )
        .ready ( function () {
            $.ajax( {
                url: baseUrl+'/make-order/get-menu',
                type: 'GET',
                dataType: 'html',
                data: {},
                success: function( res ) {
                    $('.menu_list--list').html( res )
                }
            } )
        } )
        .on( 'click', '.add_item_order', function () {
            $(this).parent().addClass('hide_actions')
            $(this).parent().siblings('.quality_product_btn').removeClass('hide_actions')

            $( '.no_orders').hide();
            $( '.checkout_btn_container').show();
            
            let productId = parseInt( $(this).attr('attr-pid') )
            let infoContainer   = $( '.prod_card-' + productId )
            let productName = infoContainer.find('.product_info--name').text()
            let productPrice = infoContainer.find('.product_info--price').text()
            let productTax = infoContainer.find('.product_info--tax').text()

            let totalPrice = ( parseFloat(productPrice) + parseFloat(productTax) ).toFixed(2)

            let htmlElem ='<tr attr-pid="'+ productId +'" class="product_sum_data--info product_id_'+ productId +'" >'
            htmlElem +='<th>'+ productName +'</th>'
            htmlElem +='<td>'+ productPrice +' + <i>'+ productTax +'</i></td>'
            htmlElem +='<td class="quantity">1</td>'
            htmlElem +='<td class="sub_total">'+ totalPrice +'</td>'
            htmlElem +='</tr>'

            let summaryContainer = $( '.template_components--summary' ).find( '#product_sum_data_area' )
            let currentTotalDue = ( parseFloat( summaryContainer.find( '.total_due' ).text() ) ).toFixed( 2 )
            
            if ( currentTotalDue  == 0 ) {
                summaryContainer.find( '.total_due' ).text( totalPrice )
            } else {
                summaryContainer.find( '.total_due' ).text( ( parseFloat( currentTotalDue ) + parseFloat( totalPrice ) ).toFixed( 2 ) )
            }

            $( '.order_table_list' ).append( htmlElem )
        } )
        .on( 'click', '.reduce_prod_quality', function () {
            let pid = $(this).attr( 'attr-pid' )
            let orderClass      = '.product_id_' + pid
            let summaryContainer = $( '.template_components--summary' ).find( '#product_sum_data_area' )
            
            let currentQuality = parseInt( $(this).siblings( '.current_quality' ).text() )
            let updateQuality = currentQuality - 1

            // get pruduct information
            let infoContainer   = $( '.prod_card-' + pid )
            let productPrice = infoContainer.find('.product_info--price').text()
            let productTax = infoContainer.find('.product_info--tax').text()

            let currentOverallTotal = summaryContainer.find( '.total_due' ).text()
            let updateOverallTotal = ( parseFloat( parseFloat( currentOverallTotal ) - ( parseFloat( productPrice ) + parseFloat( productTax ) ) ) ).toFixed(2)

            if ( currentQuality == 1 ) {
                $(this).parent().siblings('.add_product_btn').removeClass( 'hide_actions' )
                $(this).parent().addClass('hide_actions')

                $('.product_sum_data').find(orderClass).remove()

                summaryContainer.find( '.total_due' ).text( updateOverallTotal )
                
            } else {
                let totalPrice = ( ( parseFloat(productPrice) + parseFloat(productTax) ) * parseInt( updateQuality ) ).toFixed( 2 )

                $( this ).siblings('.current_quality').text( updateQuality )
                $( orderClass ).find('.quantity').text( updateQuality )
                $( orderClass ).find('.sub_total').text( totalPrice )
                
                let updateOverallTotal = ( parseFloat( parseFloat( currentOverallTotal ) - ( parseFloat( productPrice ) + parseFloat( productTax ) ) ) ).toFixed(2)
                summaryContainer.find( '.total_due' ).text( updateOverallTotal )
                
            }

            if ( updateOverallTotal == 0 ) {
                $( '.no_orders').show();
                $( '.overall_total_container').hide();
            }
        } )
        .on( 'click', '.raise_prod_quality', function () {
            let pid             = $(this).attr('attr-pid')
            let orderClass      = '.product_id_' + pid
            
            // update quality
            let currentQuality  = parseInt( $(this).siblings('.current_quality').text() )
            let updateQuality   = currentQuality + 1
            $( this ).siblings('.current_quality').text( updateQuality )
            $( orderClass ).find('.quantity').text( updateQuality )

            // update subtotal
            let infoContainer   = $( '.prod_card-' + pid )
            let productPrice    = infoContainer.find('.product_info--price').text()
            let productTax      = infoContainer.find('.product_info--tax').text()
            let totalPrice      = ( ( parseFloat(productPrice) + parseFloat(productTax) ) * parseInt( updateQuality ) ).toFixed( 2 )
            $( orderClass ).find('.sub_total').text( totalPrice )

            // update total due
            let summaryContainer = $( '.template_components--summary' ).find( '#product_sum_data_area' )
            let currentTotalDue = ( parseFloat( summaryContainer.find( '.total_due' ).text() ) ).toFixed( 2 )
            let updateOverallTotal = ( parseFloat( parseFloat( currentTotalDue ) + ( parseFloat(productPrice) + parseFloat(productTax) ) ) ).toFixed(2)
            summaryContainer.find( '.total_due' ).text( updateOverallTotal )

        } )
        .on( 'click', '.save_orders', function () {
            let ordersContainer = $( '.template_components--summary' )
            let orders = ordersContainer.find( '#product_sum_data_area' ).find( '.product_sum_data--info' )
            
            let saveOrderInfo = {
                order_total: ordersContainer.find( '.total_due' ).text(),
                coupon: ordersContainer.find( '.coupon_input_id' ).val(),
                products_list: []
            }

            
            for (let index = 0; index < orders.length; index++) {
                const element = orders.eq(index);

                saveOrderInfo.products_list.push( {
                    product_id: element.attr( 'attr-pid' ),
                    quantity: element.find( '.quantity' ).text(),
                    sub_total: element.find( '.sub_total' ).text()
                } )
            }
            
            $.ajax( {
                url: baseUrl+'/make-order/save-order',
                type: 'POST',
                dataType: 'json',
                data: saveOrderInfo,
                success: function( res ) {
                    location.reload();
                }
            } )
        } )
        .on( 'click', '.check_coupon', function () {
            $( '.save_orders' ).prop('disabled', true)
            let coupon = $( '.coupon_input' ).val()

            $.ajax( {
                url: baseUrl+'/make-order/get-coupon',
                type: 'POST',
                dataType: 'json',
                data: {coupon},
                success: function( res ) {
                    if ( res.availability ) {
                        $( '.coupon_input_id' ).val( res.data[0].id  )
                        let summaryContainer = $( '.template_components--summary' ).find( '#product_sum_data_area' )
                        let currentTotalDue = ( parseFloat( summaryContainer.find( '.total_due' ).text() ) ).toFixed( 2 )

                        $( '.coupon_discount_val' ).text('-10%')
                        
                        summaryContainer.find( '.total_due' ).text( setDiscount(currentTotalDue) )
                    } else {
                        $( '.coupon_discount_val' ).text(0)
                    }
                    $( '.save_orders' ).prop('disabled', false)
                }
            } )
        } )
        .on( 'click', '.checkout_btn', function () {
            $( '.template_components--menu' ).find('button').prop('disabled', true)
            $( '.overall_total_container' ).toggleClass('is_hidden')
            $(this).hide()
        } )
} )

function setDiscount( total ) {
    if ( $( '.coupon_discount_val' ).text() != '0' ) {
        let discount = parseFloat( total ) * .10
        return ( total - discount ).toFixed( 2 )
    }

    return total
}