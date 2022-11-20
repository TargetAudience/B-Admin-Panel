<div class="sub-menu">
    {if {$subPage} neq 'userProfile'}<a href="{$URL}users/userProfile?id={$userId}">Profile</a>{else}<span class="active">Profile</span>{/if} {if {$subPage} neq 'userPosts'}<a href="{$URL}users/usersPurchases?id={$userId}">Purchases</a>{else}<span class="active">Purchases</span>{/if}
</div>
