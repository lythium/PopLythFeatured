{if ($product_select)}
<div class="container poplythfeatured">
    <div class="popcards">
        <div class="inter-cards">
            <a href="{$link->getProductLink($product_select.id_product)|escape:'html':'UTF-8'}">
                <h3 class="name-product">{$product_name|escape:'html':'UTF-8'}</h3>
            </a>
            <div class="content">
                <div id="image-block" class="clearfix">
                    {if $product_select.new}
                        <span class="new-box">
                            <span class="new-label">{l s='New'}</span>
                        </span>
                    {/if}
                    {if $product_select.on_sale}
                        <span class="sale-box no-print">
                            <span class="sale-label">{l s='Sale!'}</span>
                        </span>
                    {elseif isset($product_select.specific_prices) && $product_select.reduction && $product_select.price_without_reduction > $product_select.price}
                        <span class="discount">{l s='Reduced price!'}</span>
                    {/if}
                    {if $have_image}
                        <a class="{$link->getProductLink($product_select.id_product)|escape:'html':'UTF-8'}" >
                            <img id="cover" itemprop="image" src="{$link->getImageLink($product_select.link_rewrite, $id_cover, 'large_default')|escape:'html':'UTF-8'}" title="{$product_name|escape:'html':'UTF-8'}"/>
                        </a>
                    {else}
                        <a class="{$link->getProductLink($product_select.id_product)|escape:'html':'UTF-8'}" >
                            <img itemprop="image" src="{$img_prod_dir}{$lang_iso}-default-large_default.jpg" id="cover" alt="" title="{$product_name|escape:'html':'UTF-8'}"/>
                        </a>
                    {/if}
                </div> <!-- end image-block -->
                <div class="content-info">
                    <div class="price-info">
                        {if $product_select.quantity > 0}<link itemprop="availability" href="https://schema.org/InStock"/>{/if}
                        {if $product_select.show_price >=0 && $product_select.show_price <= 2}
                            <span id="product_price_display" class="price" itemprop="price" content="{$price_select}">{convertPrice price=$price_select|floatval}</span>
                            <div class="price_reduction_block">
                                <span id="old_price">
                                    <span class="price">{if $product_select.price_without_reduction > $product_select.price}{convertPrice price=$product_select.price_without_reduction|floatval}{/if}</span>
                                    <!-- {if $product_select.price_without_reduction > $product_select.price && $tax_enabled && $display_tax_label == 1} {if $product_select.show_price == 1}{l s='tax excl.'}{else}{l s='tax incl.'}{/if}{/if} -->
                                </span>

                                {if $product_select.specific_prices && $product_select.specific_prices.reduction_type == 'percentage'}
                                    <span id="reduction_percent">
                                        -{$product_select.specific_prices.reduction*100}%
                                    </span>
                                {/if}

                                {if $product_select.specific_prices && $product_select.specific_prices.reduction_type == 'amount' && $product_select.specific_prices.reduction|floatval !=0}
                                    <span id="reduction_amount">
                                        -{convertPrice price=$product_select.price_without_reduction|floatval-$product_select.price|floatval}
                                    </span>
                                {/if}
                            </div>
                        {/if}
                    <!-- <pre>{$product_select|@var_dump}</pre> -->
                    </div> <!-- End Price info -->
                </div>
            </div>
            <div class="pop-action">
                <div class="button_add">
                    <a class="pop_button" href="{$link->getPageLink('cart', true, NULL, "qty=1&amp;id_product={$product_select.id_product|intval}&amp;token={$static_token}&amp;add")|escape:'html':'UTF-8'}" data-id-product="{$product_select.id_product|intval}" title="{l s='Add to cart'}">
                        <span>{l s='Add to cart'}</span>
                    </a>
                </div>
                {if $product_select.description}
                    <div class="button_details">
                        <a class="pop_button" href="{$link->getProductLink($product_select.id_product)|escape:'html':'UTF-8'}" class="button">
                            <span>{l s='More details'}</span>
                        </a>
                    </div>
                {/if}
            </div>
        </div>
    </div>
</div>
{/if}
