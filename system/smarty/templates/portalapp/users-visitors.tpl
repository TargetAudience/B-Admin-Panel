<div id="wrapper" class="page-wrap opened-max">
    {include file='portalapp/administration-sidemenu.tpl'}
    <div id="page-content-wrapper" class="container-fluid">
        <div class="content-area">
            <form action="{$URL}users/newUser" id="checkboxForm" method="post">
                <div class="table-b-wrap">
                    <table class="table-b pretty">
                        <thead>
                            <tr>
                                <th>Country</th>
                                <th>Platform</th>
                                <th>First Visit Date</th>
                                <th>Latest Visit Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach from=$userData item=user}
                                <tr>
                                    <td>{$user.device_country}</td>
                                    <td>{$user.device_platform}</td>
                                    <td>{$user.first_visit_on}</td>
                                    <td>{$user.last_visited_on}</td>
                                    <td><a href="{$URL}users/userProfile?id={$user.userIdEncoded}" class="view-link">View</a> <a href="#" data-src="{$URL}administration/remove?type=users&id={$user.userIdEncoded}&userType={$user.userType}" class="js__admin-remove-item icon-spacer"><span class="icon-trash"></span></a></td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
    {include file='portalapp/users_pagination.tpl'}
</div>

{include file='portalapp/administration-popups.tpl'}
