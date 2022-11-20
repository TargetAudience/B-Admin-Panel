<div class="sub-menu">
    {if {$subPage} neq 'profile'}<a href="{$URL}myaccount/">Profile</a>{else}<span class="active">Profile</span>{/if} {if {$subPage} neq 'resetPassword'}<a href="{$URL}myaccount/resetPassword">Reset Password</a>{else}<span class="active">Reset Password</span>{/if}
</div>
