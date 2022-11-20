<div id="sidebar-wrapper">
    <ul class="sidebar-nav nav-pills nav-stacked" id="menu">
        {if (!array_key_exists(1, $session.adminRoleIds) || array_key_exists(1, $session.role))}
            <li class="{if {$currentPage} eq 'users'}active{/if}">
                <a href="{$URL}users"><span class="icon icon-users"></span><p>Users</p></a>
            </li>
        {/if}
        {if (!array_key_exists(8, $session.adminRoleIds) || array_key_exists(8, $session.role))}
            <li class="{if {$currentPage} eq 'caregivers'}active{/if}">
                <a href="{$URL}caregivers"><span class="icon icon-users"></span><p>Caregivers</p></a>
            </li>
        {/if}
        {if (!array_key_exists(9, $session.adminRoleIds) || array_key_exists(9, $session.role))}
            <li class="{if {$currentPage} eq 'personalCareWorkers'}active{/if}">
                <a href="{$URL}personalCareWorkers"><span class="icon icon-calls"></span><p>Personal Care Workers</p></a>
            </li>
        {/if}
        {if (!array_key_exists(2, $session.adminRoleIds) || array_key_exists(2, $session.role))}
            <li class="{if {$currentPage} eq 'meals'}active{/if}">
                <a href="{$URL}meals"><span class="icon icon-reviews"></span><p>Meals</p></a>
            </li>
        {/if}
        {if (!array_key_exists(3, $session.adminRoleIds) || array_key_exists(3, $session.role))}
            <li class="{if {$currentPage} eq 'equipment'}active{/if}">
                <a href="{$URL}equipment"><span class="icon icon-reviews"></span><p>Equipment</p></a>
            </li>
        {/if}
        {if (!array_key_exists(10, $session.adminRoleIds) || array_key_exists(10, $session.role))}
            <li class="{if {$currentPage} eq 'transportation'}active{/if}">
                <a href="{$URL}transportation"><span class="icon icon-reviews"></span><p>Transportation</p></a>
            </li>
        {/if}
        {if (!array_key_exists(4, $session.adminRoleIds) || array_key_exists(4, $session.role))}
            <li class="{if {$currentPage} eq 'purchases'}active{/if}">
                <a href="{$URL}purchases"><span class="icon icon-reviews"></span><p>Purchases</p></a>
            </li>
        {/if}
        {if (!array_key_exists(5, $session.adminRoleIds) || array_key_exists(5, $session.role))}
            <li class="{if {$currentPage} eq 'promoCodes'}active{/if}">
                <a href="{$URL}promoCodes"><span class="icon icon-users"></span><p>Promo Codes</p></a>
            </li>
        {/if}
        {if (!array_key_exists(6, $session.adminRoleIds) || array_key_exists(6, $session.role))}
            <li class="{if {$currentPage} eq 'pushNotifications'}active{/if}">
                <a href="{$URL}pushNotifications"><span class="icon icon-users"></span><p>Push Notifications</p></a>
            </li>
        {/if}
        {if (!array_key_exists(7, $session.adminRoleIds) || array_key_exists(7, $session.role))}
            <li class="{if {$currentPage} eq 'adminUsers'}active{/if}">
                <a href="{$URL}adminUsers"><span class="icon icon-users"></span><p>Admin Users</p></a>
            </li>
        {/if}   
    </ul>
</div>
