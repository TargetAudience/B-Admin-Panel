<div class="sub-menu">
    {if {$subPage} neq 'rent'}<a href="{$URL}equipment?type=rent">Rental Items ({$equipmentRentalCount})</a>{else}<span class="active">Rental Items ({$equipmentRentalCount})</span>{/if} {if {$subPage} neq 'purchase'}<a href="{$URL}equipment?type=purchase">Purchase Items ({$equipmentPurchaseCount})</a>{else}<span class="active">Purchase Items ({$equipmentPurchaseCount})</span>{/if}
</div>
