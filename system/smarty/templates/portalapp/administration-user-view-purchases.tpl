<div id="wrapper" class="page-wrap opened-max">
    {include file='portalapp/administration-sidemenu.tpl'}
    <div id="page-content-wrapper" class="container-fluid gap-top">
        <div class="content-area">
            <div class="navbar navbar-admin">
                <div class="left-align-b buttons-wrap">
                    <input onclick="location.href='{$URL}users';"
                        type="button"
                        class="button-global smallb hollow"
                        name="button_click"
                        value="← RETURN TO USERS">
                </div>
            </div>
            {if $subPage != 'newUser'}
                {include file='portalapp/administration-submenu.tpl' currentPage={$subPage} userId={$userIdEncoded}}
            {/if}
            <div class="table-b-wrap">
                <table class="table-b pretty" id="sortedTable">
                    <thead>
                        <tr>
                            <th>Purchase Type</th>
                            <th>Order Id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Total Amount</th>
                            <th>Purchase Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$userData item=user}
                            <tr>
                                <td>{$user.verticalFriendly}</td>
                                <td>{$user.customerOrderId}</td>
                                <td>{$user.firstName}</td>
                                <td>{$user.lastName}</td>
                                <td>${$user.total}</td>
                                <td>{$user.dateCreated}</td>
                                <td><a href="{$URL}users/details?id={$user.purchaseIdEncoded}" class="view-link">View</a> <a href="#" data-src="{$URL}administration/remove?type=usersPurchases&id={$user.purchaseid}" class="js__admin-remove-item icon-spacer"><span class="icon-trash"></span></a></td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {include file='portalapp/users_pagination.tpl'}
</div>

{include file='portalapp/administration-popups.tpl'}