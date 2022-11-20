<div id="wrapper" class="page-wrap opened-max">
    {include file='portalapp/administration-sidemenu.tpl'}
    <div id="page-content-wrapper" class="container-fluid gap-top">
        <div class="content-area">
            <div class="navbar navbar-admin">
                <div class="left-align-b buttons-wrap">
                    <button onclick="location.href='{$URL}adminUsers/addUser'" type="button" class="button-global smallb">ADD ADMIN USER</button>
                </div>
            </div>
            <div class="table-b-wrap">
                <table class="table-b pretty">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Date Created</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$userData item=user}
                            <tr>
                                <td>{$user.firstName}</td>
                                <td>{$user.lastName}</td>
                                <td>{$user.emailAddress}</td>
                                <td>{$user.role}</td>
                                <td>{$user.dateCreated}</td>
                                <td><a href="{$URL}adminUsers/userProfile?id={$user.userIdEncoded}" class="view-link">View</a> <a href="#" data-src="{$URL}administration/remove?type=adminUsers&id={$user.userIdEncoded}" class="js__admin-remove-item icon-spacer"><span class="icon-trash"></span></a></td>
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