{if ($product)}
<div class="container poplythfeatured">
    <div class="popcards col-md-4">
        <div class="inter-cards">
            <a href="{$link->getProductLink($product)|escape:'html':'UTF-8'}">
                <h3 class="name-product">{$product_name|escape:'html':'UTF-8'}</h3>
            </a>
            <div class="content">
                <div id="image-block" class="clearfix">
                    {if $product->new}
                        <span class="new-box">
                            <span class="new-label">{l s='New'}</span>
                        </span>
                    {/if}
                    {if $product->on_sale}
                        <span class="sale-box no-print">
                            <span class="sale-label">{l s='Sale!'}</span>
                        </span>
                    {elseif isset($product->specific_prices) && $product->reduction && $product->price_without_reduction > $product->price}
                        <span class="discount">{l s='Reduced price!'}</span>
                    {/if}
                    {if $have_image}
                        <span id="view_full_size">
                            {if $have_image }
                                <a class="{$link->getProductLink($product)|escape:'html':'UTF-8'}" >
                                    <img itemprop="image" src="{$link->getImageLink($product->link_rewrite[1], $product->id +1, 'large_default')|escape:'html':'UTF-8'}" />
                                </a>
                            {else}
                                <a class="{$link->getProductLink($product)|escape:'html':'UTF-8'}" >
                                    <img itemprop="image" />
                                </a>
                            {/if}
                        </span>
                    {else}
                        <span id="view_full_size">
                            <a class="{$link->getProductLink($product)|escape:'html':'UTF-8'}" >
                                <img itemprop="image" />
                            </a>
                        </span>
                    {/if}
                </div> <!-- end image-block -->
                <div class="text-content">
                    <!-- <pre>{$product|@var_dump}</pre> -->
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
