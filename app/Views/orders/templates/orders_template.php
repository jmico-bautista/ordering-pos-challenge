<div id="homepage_orders_template">
    <div class="orders_list">
        <?php if ( ! empty( $orders ) ): ?>
            <?php foreach ($orders as $key => $order):?>

                <div class="card order text-white bg-secondary">
                    <div class="card-body">
                        <h5 class="card-title">OID: <?=$order['name']?></h5>
                        <p class="card-text">Posted: <?=$order['date_created']?></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($order['products'] as $p_key => $product):?>
                            <li class="list-group-item">
                            <div class="row product">
                                    <div class="col column--left">
                                        <span class="product_name"><?=$product['name']?></span>
                                    </div>
                                    <div class="col column--right">
                                        <span></span>
                                    </div>
                                </div>
                                <div class="row product">
                                    <div class="col column--left">
                                        <span>Unit Price</span>
                                    </div>
                                    <div class="col column--right">
                                        <span><?=$product['price']?> + <i><?=$product['tax']?></i></span>
                                    </div>
                                </div>
                                <div class="row product">
                                    <div class="col column--left">
                                        <span>Quantity</span>
                                    </div>
                                    <div class="col column--right">
                                        <span>x <?=$product['quantity']?></span>
                                    </div>
                                </div>
                                <div class="row product">
                                    <div class="col column--left"></div>
                                    <div class="col column--right">
                                        <hr class="dropdown-divider">
                                        <span><?=$product['sub_total']?></span>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach;?>
                    </ul>

                    <div class="card-footer">
                        <?php if( $order['coupon_id'] ): ?>
                            <div class="row">
                                <div class="col column--left">
                                    <span>( <?=$coupons[$order['coupon_id']]['code']?> )  </span>
                                </div>
                                <div class="col column--right">
                                    <span>-10%</span>
                                </div>
                            </div>
                        <?php endif;?>
                        <div class="row">
                            <div class="col column--left">
                                <span>Total</span>
                            </div>
                            <div class="col column--right">
                                <span><?=$order['total']?></span>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php endif;?>
    </div>
</div>