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
        $product_id = $this->researchProduct($log);
        $test = Product::getRandomSpecial($this->context->language->id);
        die(var_dump($test));
        if ($product_id) {
            $product = new Product($product_id);
            $price = $product->specificPrice;
            var_dump($price);
        } else {
            $product = false;
        }

        // Stock Variable
        $this->context->smarty->assign(array(
           'product' => $product,
        ));

        return $this->display(__FILE__, '/views/templates/hook/poplythfeatured.tpl');
    }

    private function researchProduct($log)
    {
        if ($log) {
            # code...
        } else {
            $sql = new DbQuery();
            $sql->select('p.id_product');
            $sql->from('product', 'p');
            $sql->where('on_sale = 1');
            $sql->where('available_for_order = 1');
            $sql->orderBy('RAND()');
            $result = Db::getInstance()->getValue($sql);
            if (empty($result)) {
                $sql = new DbQuery();
                $sql->select('s.id_product');
                $sql->from('specific_price', 's');
                $sql->orderBy('RAND()');
                $result = Db::getInstance()->getValue($sql);
                if (!empty($result)) {
                    $sql = new DbQuery();
                    $sql->select('p.id_product');
                    $sql->from('product', 'p');
                    $sql->where('id_product = '.$result);
                    $sql->where('available_for_order = 1');
                    $result = Db::getInstance()->getValue($sql);
                } else {
                    $sql = new DbQuery();
                    $sql->select('p.id_product');
                    $sql->from('product', 'p');
                    $sql->where('available_for_order = 1');
                    $sql->orderBy('id_product DESC');
                    $result = Db::getInstance()->getValue($sql);
                }
            }
        }
        return $result;
        var_dump($result);
    }
}
