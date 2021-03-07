<div id="homepage_menu_list_template">

    <div class="template_components--summary">
        <div id="product_sum_data_area" class="product_sum_data">
            
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Sub-total</th>
                    </tr>
                </thead>
                
                <tbody class="order_table_list">
                    <!-- append data here -->
                    <tr>
                        <th class="no_orders" scope="row" colspan="4"><i>No orders</i></th>
                    </tr>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="total_due_label" colspan="3">Total Due</th>
                        <td class="total_due">0.00</td>
                    </tr>
                    <tr>
                        <th class="" colspan="3">Coupon Discount</th>
                        <td class="coupon_discount_val">0</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="row checkout_btn_container is_hidden">
            <div class="col column--left d-grid">
                <button type="button" class="btn btn-secondary checkout_btn"> Checkout </button>
            </div>
        </div>

        <div class="overall_total_container is_hidden">
            <div class="final_checkout">
                <div class="row">
                    <input type="hidden" class="coupon_input_id" value="0" aria-describedby="button-addon2">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control coupon_input" placeholder="Discount Coupon Here!" aria-label="Discount Coupon Here!" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary check_coupon" type="button" id="button-addon2">Check</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col column--left d-grid">
                        <button type="button" class="btn btn-secondary save_orders"> Save Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="template_components--menu">
        <?php foreach ($menu as $key => $category): ?>
            <div class="menu_category d-block">
                <div class="menu_category--title">
                    <span><?=$category['name']?></span>
                </div>

                <div class="menu_category--items">
                    <?php foreach ( $category['items'] as $item_key => $item ): ?>
                        <div class="product card prod_card-<?=$item['id']?> text-white bg-secondary mb-3 ">
                            <div class="product_info row">
                                <span class="product_info--name"> <?=$item['name']?> </span>
                                <br/>
                                <span> <?=number_format( $item['price'] + $item['tax'], 2)?> </span>
                                <span class="product_info--price"> <?=$item['price']?> </span>
                                <span class="product_info--tax"> <?=$item['tax']?> </span>
                            </div>

                            <div class="row">
                                <div class="menu_category_actions">
                                    <div class="add_product_btn">
                                        <button type="button" class="add_item_order btn btn-dark" attr-pid="<?=$item['id']?>"><i class="fas fa-plus"></i></button>
                                    </div>

                                    <div class="quality_product_btn hide_actions">
                                        <button type="button" class="reduce_prod_quality btn btn-dark" attr-pid="<?=$item['id']?>"><i class="fas fa-minus"></i></button>
                                        <span class="current_quality">1</span>
                                        <button type="button" class="raise_prod_quality btn btn-dark" attr-pid="<?=$item['id']?>"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>