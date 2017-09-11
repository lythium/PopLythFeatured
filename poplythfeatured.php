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
        if ($this->context->customer->isLogged() || $this->context->customer->isGuest()) {
            $product = false;
            $product = $this->researchSuitableProduct();
        } else {
            $product = $this->researchProductSpecial();
        }

        // Stock Variable
        if ($product) {
            $have_image = ImageCore::hasImages($this->context->language->id, (int)$product["id_product"]);
            $cover = Product::getCover((int)$product["id_product"]);
            // $price = Combination::getPrice($product["id_product_attribute"]);
            // die(var_dump($product));
            // die(var_dump($price));
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
            // if ($product["specific_prices"]) {
            //     $this->context->smarty->assign(array(
            //         'reduction' => $product["specific_prices"]["reduction"],
            //     ));
            // };
        }

        return $this->display(__FILE__, '/views/templates/hook/poplythfeatured.tpl');
    }

    private function researchProductSpecial()
    {
        $result = Product::getRandomSpecial($this->context->language->id);
        // $result = New Product($result["id_product"]);
        // die(var_dump($result));
        if (empty($result) || !$result) {
            $result = Product::getNewProducts($this->context->language->id,$page_number = 0, $nb_products = 3);
            $count = count($result) - 1;
            $result = $result[rand(0, $count)];
        }
        return $result;
    }
    private function researchSuitableProduct()
    {
        $array = Order::getCustomerOrders($this->context->customer->id, $show_hidden_status = true);
        // $order = New Order($array[0]["id_order"]);
        $orderValid = array_filter($array, function ($key, $value){
            if($key == 'valid' && $value == 1)
                {
                    return true;
                }   else {
                    return false;
                }
            }, ARRAY_FILTER_USE_BOTH);
            if (count($orderValid) > 0) { // if isset product on sale display $result
                $result = $orderValid;
            } else { // if !isset product on sale research product with reduction
                $result = "null";
            }
        die(var_dump($result));
        return $result;
    }
}
