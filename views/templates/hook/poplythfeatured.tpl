{if ($product_select)}
{if !$priceDisplay || $priceDisplay == 2}
    {assign var='productPrice' value=$product_select->getPrice(true, $smarty.const.NULL, 6)}
    {assign var='productPriceWithoutReduction' value=$product_select->getPriceWithoutReduct(false, $smarty.const.NULL)}
{elseif $priceDisplay == 1}
    {assign var='productPrice' value=$product_select->getPrice(false, $smarty.const.NULL, 6)}
    {assign var='productPriceWithoutReduction' value=$product_select->getPriceWithoutReduct(true, $smarty.const.NULL)}
{/if}
<div class="container poplythfeatured">
    <div class="popcards">
        <div class="inter-cards">
            <a href="{$link->getProductLink($product_select->id)|escape:'html':'UTF-8'}">
                <h3 class="name-product">{$product_name|escape:'html':'UTF-8'}</h3>
            </a>
            <div class="content">
                <div id="image-block" class="clearfix">
                    {if $product_select->new}
                        <span class="new-box">
                            <span class="new-label">{l s='New'}</span>
                        </span>
                    {/if}
                    {if $product_select->on_sale}
                        <span class="sale-box no-print">
                            <span class="sale-label">{l s='Sale!'}</span>
                        </span>
                    {elseif $product_select->specificPrice && $product_select->specificPrice.reduction && $productPriceWithoutReduction > $productPrice}
                        <span class="discount">{l s='Reduced price!'}</span>
                    {/if}
                    {if $have_image}
                    <a class="{$link->getProductLink($product_select->id)|escape:'html':'UTF-8'}" >
                        <img id="cover" itemprop="image" src="{$link->getImageLink($product_select->link_rewrite, $cover.id_image, 'large_default')|escape:'html':'UTF-8'}" />
                    </a>
                    {else}
                    <a class="{$link->getProductLink($product_select->id)|escape:'html':'UTF-8'}" >
                        <img itemprop="image" src="{$img_prod_dir}{$lang_iso}-default-large_default.jpg" id="cover" alt="" title="{$product->name|escape:'html':'UTF-8'}" width="{$largeSize.width}" height="{$largeSize.height}"/>
                    </a>
                    {/if}
                </div> <!-- end image-block -->
                <div class="text-content">
                    <pre>{$product_select|@var_dump}</pre>
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
