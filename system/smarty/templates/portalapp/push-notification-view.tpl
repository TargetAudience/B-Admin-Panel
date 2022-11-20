<div id="wrapper" class="page-wrap print opened-max">
    {include file='portalapp/administration-sidemenu.tpl'}
    <div id="page-content-wrapper" class="container-fluid">
        <div class="content-area">
            <div class="navbar navbar-admin">
                <div class="left-align-b buttons-wrap">
                    <input onclick="location.href='{$URL}pushNotifications';"
                        type="button"
                        class="button-global smallb hollow"
                        name="button_click"
                        value="← RETURN TO PUSH NOTIFICATIONS">
                </div>
            </div>
            {include file='portalapp/push-notifications-submenu.tpl'}
            <div class="section-wrap">
                <div class="left-align-b buttons-wrap">
                    <button onclick="location.href='edit?id={$pushNotificationIdEncoded}'" type="button" class="button-global smallb">EDIT PUSH NOTIFICATION</button>
                    <button onclick="location.href='send?id={$pushNotificationIdEncoded}'" type="button" class="button-global smallb">SEND</button>
                </div>

                <div class="table-c-wrap">
                    <table class="table-c">
                        <tr>
                            <td>Internal Name:</td>
                            <td>{$notificationData.internalName}</td>
                        </tr>
                        <tr>
                            <td>Message Title:</td>
                            <td>{$notificationData.messageTitle}</td>
                        </tr>
                        <tr>
                            <td>Message:</td>
                            <td>{$notificationData.messageBody}</td>
                        </tr>
                        <tr>
                            <td>Created On:</td>
                            <td>{$notificationData.createdOn}</td>
                        </tr>
                        <tr>
                            <td>Updated On:</td>
                            <td>{$notificationData.lastUpdate}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
