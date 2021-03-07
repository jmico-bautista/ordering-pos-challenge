<?php
namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

use App\Models\MenuModel;
use App\Models\MenuCategoriesModel;
use App\Models\Coupons;
use App\Models\Orders;
use App\Models\Products;
use App\Models\OrdersProductsRef;

class MakeOrder extends BaseController {
    use ResponseTrait;

    public function __construct() {
        helper( ['common'] );
    }

    public function index() {
        $data = [];
        
        $data['css_list'] = [
            'css/sidebar.css',
            'css/make_order.css',
            'css/body_style.css',
        ];

        $data['js_list'] = [
            'js/make_order.js',
        ];

        echo view('layout/base_head_layout.php', $data);
        echo view('layout/sidebar/sidebar.php');
        echo view('make_order/make_order.php');
    }

    public function get_menu() {

        $data = [];

        $db_menu = new MenuModel();
        $db_menu_categories = new MenuCategoriesModel();

        $menu_list = $db_menu->findAll();
        $data['menu'] = $db_menu_categories->findAll();
        $data['menu'] = set_array_key( $data['menu'], 'id');
        
        foreach ($menu_list as $key => $value) {
            if ( ! isset ( $data['menu'][ $value['category'] ]['items'] ) ) {
                $data['menu'][ $value['category'] ]['items'] = [];
            }

            array_push( $data['menu'][ $value['category'] ]['items'], $value );
        }
        
        echo view('make_order/templates/menu_template.php', $data);
    }

    public function save_order() {
        
        $db_orders = new Orders();
        $db_products = new Products();
        $db_orders_products_ref = new OrdersProductsRef();

        $new_order = [
            'name' => date("mdyhis"),
            'total' => $this->request->getVar( 'order_total' ),
            'coupon_id' => $this->request->getVar( 'coupon' )
        ];
        
        $order_id = $db_orders->insert( $new_order );
        
        if ( $order_id ) {
            foreach ( $this->request->getVar( 'products_list' ) as $key => $product_info ) {
                $product_saved_id = $db_products->insert( $product_info );

                if ( $product_saved_id ) {
                    $new_reference = [
                        'order_id' => $order_id,
                        'product_id' => $product_saved_id
                    ];
                    
                    $db_orders_products_ref->insert( $new_reference );
                }
            }
        }

        return $this->respond([ 'message' => "Order saved" ], 201);
    }

    public function check_coupon () {
        $db_coupons = new Coupons();
        $is_available = $db_coupons->where( 'code', $this->request->getVar( 'coupon' ) )->findAll();
        return $this->respond([ 'availability' => $is_available ? true : false, 'data' => $is_available ], 201);
    }

}
?>