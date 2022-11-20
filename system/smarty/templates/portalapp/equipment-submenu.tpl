<div class="sub-menu">
    {if {$subPage} neq 'details'}<a href="{$URL}equipment/item?id={$itemIdEncoded}&type={$type}">Details</a>{else}<span class="active">Details</span>{/if}{if $type eq 'rent'}{if {$subPage} neq 'pricing'}<a href="{$URL}equipment/pricing?id={$itemIdEncoded}&type={$type}">Pricing</a>{else}<span class="active">Pricing</span>{/if}{if {$subPage} neq 'sizes'}<a href="{$URL}equipment/sizes?id={$itemIdEncoded}&type={$type}">Sizes</a>{else}<span class="active">Sizes</span>{/if}
    {/if}{if in_array('Admin', $session.role)}{if {$subPage} neq 'images'}<a href="{$URL}equipment/images?id={$itemIdEncoded}&type={$type}">Images</a>{else}<span class="active">Images</span>{/if}{/if}
</div>
