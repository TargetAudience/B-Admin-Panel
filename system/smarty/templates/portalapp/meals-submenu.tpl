<div class="sub-menu">
    {if {$subPage} neq 'details'}<a href="{$URL}meals/item?id={$mealItemIdEncoded}">Details</a>{else}<span class="active">Details</span>{/if}{if {$subPage} neq 'image'}<a href="{$URL}meals/image?id={$mealItemIdEncoded}">Image</a>{else}<span class="active">Image</span>{/if}
</div>
