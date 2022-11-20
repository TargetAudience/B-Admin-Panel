<div class="sub-menu">
    {if {$subPage} neq 'details'}<a href="{$URL}pushNotifications/notificationView?id={$mealItemIdEncoded}">Details</a>{else}<span class="active">Details</span>{/if}
    {if {$subPage} neq 'logs'}<a href="{$URL}pushNotifications/logs?id={$mealItemIdEncoded}">Logs</a>{else}<span class="active">Logs</span>{/if}
</div>
