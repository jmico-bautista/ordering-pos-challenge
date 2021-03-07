<?php
namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\Orders;
use App\Models\Coupons;
use App\Models\Products;
use App\Models\OrdersProductsRef;

class ViewOrders extends BaseController {

    public function __construct() {
        helper( ['common'] );
    }

    public function index() {
        $data = [];
        
        $data['css_list'] = [
            'css/sidebar.css',
            'css/body_style.css',
            'css/orders.css',
        ];

        $data['js_list'] = [
            'js/orders.js',
        ];

        echo view('layout/base_head_layout.php', $data);
        echo view('layout/sidebar/sidebar.php');
        echo view('orders/orders.php');
    }

    public function get_orders() {
        $data = [];
        
        $db_orders = new Orders;
        $db_products = new Products;
        $db_coupons = new Coupons;
        $db_order_products_ref = new OrdersProductsRef;

        $data['orders'] = $db_orders->findAll();
        $data['orders'] = set_array_key( $data['orders'], 'id' );

        $data['coupons'] = $db_coupons->findAll();
        $data['coupons'] = set_array_key( $data['coupons'], 'id' );

        $orders_prod_ref = $db_order_products_ref->join( 'products', 'orders_products_ref.product_id = products.id', 'left' )
                                                    ->join( 'menu', 'products.product_id = menu.id', 'left' )->findAll();
        
        foreach ($orders_prod_ref as $key => $value) {

            if ( ! isset( $data['orders'][$value['order_id']]['products'] ) ) {
                $data['orders'][$value['order_id']]['products'] = [];
            }
            
            array_push( $data['orders'][$value['order_id']]['products'], $value );
        }
        
        echo view( 'orders/templates/orders_template.php', $data );
    }
}
?>