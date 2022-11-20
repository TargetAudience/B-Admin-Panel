<div id="wrapper" class="page-wrap opened-max">
    {include file='portalapp/administration-sidemenu.tpl'}
    <div id="page-content-wrapper" class="container-fluid gap-top">
        <div class="content-area">
            <div class="navbar navbar-admin">
                <div class="left-align-b buttons-wrap">
                    <button onclick="location.href='{$URL}pushNotifications/add'" type="button" class="button-global smallb">NEW PUSH NOTIFICATION</button>
                </div>
            </div>
            <div class="table-b-wrap">
                <table class="table-b pretty">
                    <thead>
                        <tr>
                            <th>Internal Name</th>
                            <th>Title</th>
                            <th>Body</th>
                            <th>Added On</th>
                            <th>Last Update On</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$notificationsData item=item}
                            <tr>
                                <td>{$item.internalName}</td>
                                <td>{$item.messageTitle}</td>
                                <td>{$item.messageBody}</td>
                                <td>{$item.createdOn}</td>
                                <td>{$item.updatedOn}</td>
                                <td><a href="{$URL}pushNotifications/notificationView?id={$item.pushNotificationIdEncoded}" class="view-link">View</a> <a href="#" data-src="{$URL}administration/remove?type=pushNotification&id={$item.pushNotificationIdEncoded}" class="js__admin-remove-item icon-spacer"><span class="icon-trash"></span></a></td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{include file='portalapp/administration-popups.tpl'}
