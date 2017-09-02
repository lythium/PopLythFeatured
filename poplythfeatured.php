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
        $product = $this->researchProduct($log);
        $have_image = ImageCore::hasImages($this->context->language->id, $product->id);
        $link_image = $this->context->controller->link->getImageLink($product->link_rewrite[1], $product->id, "cover");
        // die(var_dump($product));
        // Stock Variable
        $this->context->smarty->assign(array(
           'product_select' => $product,
           'have_image' => $have_image,
           'product_name' => $product->name[1],
           'link_image' => $link_image,
        ));

        return $this->display(__FILE__, '/views/templates/hook/poplythfeatured.tpl');
    }

    private function researchProduct($log)
    {
        if ($log) {
            # code...
        } else {
            $result = Product::getRandomSpecial($this->context->language->id);
            $result = New Product($result["id_product"]);
            if (empty($result)) {
                $sql = new DbQuery();
                $sql->select('p.id_product');
                $sql->from('product', 'p');
                $sql->where('active = 1');
                $sql->orderBy('id_product DESC');
                $id_product = Db::getInstance()->getValue($sql);
                $result = New Product($id_product);
            }
        }
        return $result;
    }
}
