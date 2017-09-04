{if ($product_select)}
<div class="container poplythfeatured">
    <div class="popcards">
        <div class="inter-cards">
            <a href="{$link->getProductLink($product_select["id_product"])|escape:'html':'UTF-8'}">
                <h3 class="name-product">{$product_name|escape:'html':'UTF-8'}</h3>
            </a>
            <div class="content">
                <div id="image-block" class="clearfix">
                    {if $product_select["new"]}
                    <span class="new-box">
                        <span class="new-label">{l s='New'}</span>
                    </span>
                    {/if}
                    {if $product_select["on_sale"]}
                    <span class="sale-box no-print">
                        <span class="sale-label">{l s='Sale!'}</span>
                    </span>
                    {elseif isset($product_select["specific_prices"]) && $product_select["reduction"] && $product_select["price_without_reduction"] > $product_select["price"]}
                    <span class="discount">{l s='Reduced price!'}</span>
                    {/if}
                    {if $have_image}
                    <a class="{$link->getProductLink($product_select["id_product"])|escape:'html':'UTF-8'}" >
                        <img id="cover" itemprop="image" src="{$link->getImageLink($product_select["link_rewrite"], $id_cover, 'large_default')|escape:'html':'UTF-8'}" title="{$product_name|escape:'html':'UTF-8'}"/>
                    </a>
                    {else}
                    <a class="{$link->getProductLink($product_select["id_product"])|escape:'html':'UTF-8'}" >
                        <img itemprop="image" src="{$img_prod_dir}{$lang_iso}-default-large_default.jpg" id="cover" alt="" title="{$product_name|escape:'html':'UTF-8'}"/>
                    </a>
                    {/if}
                </div> <!-- end image-block -->
                <div class="text-content">
                    <!-- <pre>{$product_select|@var_dump}</pre> -->
                </div>
            </div>
            <div class="pop-action">
                <button class="btn btn-more" type="button" name="button">More Details</button>
                <button class="btn btn-add-cart" type="button" name="button">Add to card</button>
            </div>
        </div>
    </div>
</div>
{/if}
