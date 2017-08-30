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
            $result = (bool)true;
        } else {
            $result = (bool)false;
        }
        $products = "bad";
        $this->researchProduct($result);
        $this->context->smarty->assign(array(
           'produits' => $products
        ));
        return $this->display(__FILE__, '/views/templates/hook/poplythfeatured.tpl');
    }
    private function researchProduct($logged)
    {
        if ($logged) {
            $var = "yes";
        } else {
            $var = "no";
        };
        $productObj = New Product();
        $products = $productObj::getProducts($this->context->language->id, 1, 10, 'id_product', 'DESC', $only_active = true, $on_sale = true);
        $productdiscount = $products->isDiscounted();
        var_dump($products);

        return $products;
    }
}
