<?php
/**
 * Project : PopLythFeatured
 * @author Lythium
 * @link https://www.Lythium.fr
 * @copyright Lythium
 * @license Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
 */

if (!defined('_PS_VERSION_'))
    exit;

class PopLythFeatured extends Module {

    public function __construct()
    {
        $this->name = 'poplythfeatured' ;
        $this->tab = 'front_office_features';
        $this->version = '0.1';
        $this->author = 'Lythium';

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('PopLythFeatured');
        $this->description = $this->l('display in home the featured product');
        $this->confirmUninstall = $this->l('Are you sure you want to delete these details?');
    }

    public function install()
    {
        return parent::install()
            && $this->registerHook('header')
            && $this->registerHook('displayFooter');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/poplythfeatured.js', 'all');
        $this->context->controller->addCSS($this->_path.'/views/css/poplythfeatured.css', 'all');
    }

    public function hookDisplayFooter()
    {
        $product_id = false;
        // die(var_dump($product));
        $product_id = $this->researchSuitableProduct();
        // die(var_dump($product_id));
        if (!$product_id) {
            $product_id = $this->researchProductSpecial();
        };


        // Stock Variable
        if ($product) {
            $have_image = ImageCore::hasImages($this->context->language->id, (int)$product["id_product"]);
            $cover = Product::getCover((int)$product["id_product"]);
            $this->context->smarty->assign(array(
                'product_select' => $product,
                'have_image' => (bool)$have_image,
                'id_cover' => (int)$cover["id_image"],
                'product_name' => (string)$product["name"],
            ));
            if ($product["show_price"]) {
                $this->context->smarty->assign(array(
                    'price_select' => $product["price"],
                    // 'priceWithoutReduction' => $product["price_without_reduction"],
                ));
            };

        }

        return $this->display(__FILE__, '/views/templates/hook/poplythfeatured.tpl');
    }

    private function researchProductSpecial()
    {
        $result = Product::getRandomSpecial($this->context->language->id);
        if (empty($result) || !$result) {
            $result = Product::getNewProducts($this->context->language->id,$page_number = 0, $nb_products = 3);
            $result = array_rand($result);
        }
        return (int)$result["id_product"];
    }

    private function researchSuitableProduct()
    {
        if ($this->context->customer->isLogged() || $this->context->customer->isGuest()) {
            $customer_orders = Order::getCustomerOrders($this->context->customer->id, $show_hidden_status = true);

            if (!$customer_orders) {
                return false;
            }

            $product_ids = array();
            foreach ($customer_orders as $order) {
                if ($order["valid"] == 1) {
                    $order_details = OrderDetail::getList($order['id_order']);
                    foreach ($order_details as $details) {
                        $specificPrices = SpecificPrice::getByProductId((int)$details['product_id']);
                        if (!empty($specificPrices)) {
                            $product_ids[] = (int)$specificPrices[0]['id_product'];
                        }
                    }
                }
            }
            $product_ids = array_unique($product_ids);
            // die(var_dump($product_ids));
            if (!$product_ids) {
                return false;
            }

            return array_rand($product_ids);
        } else {
            return false;
        }
    }
}
