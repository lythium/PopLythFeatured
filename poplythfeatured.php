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
            $log = (bool)true;
        } else {
            $log = (bool)false;
        }
        $result = "bad";
        $discount = "false";
        $result = $this->researchProduct($log);

        // Stock Variable
        $this->context->smarty->assign(array(
           'test' => $result,
           'discount' => $discount
        ));
        return $this->display(__FILE__, '/views/templates/hook/poplythfeatured.tpl');
    }

    private function researchProduct($log)
    {
        $products = Product::getProducts($this->context->language->id, 1, null, 'id_product', 'DESC');
        if ($log) {
            // if user log check with last order
        } else {
            $resultTest = $this::filterArrayKey($products, "on_sale", "1");
            if (count($resultTest) > 0) { // if isset product on sale display $result
                $result = $resultTest;
            } else { // if !isset product on sale research product with reduction

            }

        };
        return $result;
    }
    private static function filterArrayKey($array, $filterKey, $filterValue) {
        $result = array();
        // Stock in new array if $filterKey => $filterValue
        foreach ($array as $key){
            if ($key[$filterKey] == $filterValue) {$result[]=$key;}
        };
        return $result;
    }
}
