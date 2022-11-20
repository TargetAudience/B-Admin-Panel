<div id="wrapper" class="page-wrap opened-max">
    {include file='portalapp/administration-sidemenu.tpl'}
    <div id="page-content-wrapper" class="container-fluid gap-top">
        <div class="content-area">
            <div class="navbar navbar-admin">
                <div class="left-align-b buttons-wrap">
                    <form action="{$URL}promoCodes/create" method="post">
                        <input type="submit" class="button-global smallb" name="button_click" value="ADD PROMO CODE" />
                    </form>
                </div>
            </div>
            <div class="table-b-wrap">
                <table class="table-b pretty">
                    <thead>
                        <tr>
                            <th>Promo Code</th>
                            <th>Discount</th>
                            <th>Minimum Purchase</th>
                            <th>Specific User</th>
                            <th>Specific Vertical</th>
                            <th>Expires On</th>
                            <th>Created On</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$userData item=user}
                            <tr>
                                <td>{$user.promoCode}</td>
                                <td>{$user.discount}</td>
                                <td>{$user.minimumPurchase}</td>
                                <td>{$user.firstName} {$user.lastName}</td>
                                <td>{$user.specificVertical}</td>
                                <td>{$user.expiresOn}</td>
                                <td>{$user.createdOn}</td>
                                <td><a href="{$URL}promoCodes/details?id={$user.promoCodeId}" class="view-link">View</a> <a href="#" data-src="{$URL}administration/remove?type=promoCodes&id={$user.promoCodeId}" class="js__admin-remove-item icon-spacer"><span class="icon-trash"></span></a></td>
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