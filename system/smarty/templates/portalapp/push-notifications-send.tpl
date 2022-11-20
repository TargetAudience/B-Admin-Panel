<div id="wrapper" class="page-wrap print opened-max">
    {include file='portalapp/administration-sidemenu.tpl' currentPage={$currentPage}}
    <div id="page-content-wrapper" class="container-fluid">
        <div class="content-area">
            <div class="navbar navbar-admin">
                <div class="left-align-b buttons-wrap">
                    <input onclick="location.href='{$URL}pushNotifications';" type="button" class="button-global smallb hollow" name="button_click" value="&larr; RETURN TO PUSH NOTIFICATIONS" />
                </div>
            </div>

            <div class="section-wrap nopadding">
                <form accept-charset="UTF-8" id="js__push-notification-send" class="form-admin" data-src="{$URL}pushNotifications/sendNotification" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="notificationsIdEncoded" value="{$notificationsIdEncoded}" />
                    <div class="left-align-indent">
                        <input onclick="location.href='{$URL}pushNotifications/notificationView?id={$notificationsIdEncoded}';"
                            type="button"
                            class="button-global-mini"
                            name="button_click"
                            value="← RETURN">
                    </div>
                    <div class="optional-wrap">
                        <div class="section-input">
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Send to <span>*</span></span></div>
                                <select name="selectPushType" id="js__select-push-type">
                                    <option value="">Please Select</option>
                                    <option value="singleUser">Single User</option>
                                    <option value="allUsers">All Users ({$pushCount})</option>
                                </select>
                            </div>
                            <div class="field-set single-user-push" id="js__single_user_push">
                                <div class="form-label-wrap"><span class="label">Single User <span>*</span></span></span></div>
                                <input type="text" id="userPushAutoComplete" name="userPushAutoComplete" maxlength="64" value="" class="input short" autocomplete='family-name' />
                                <input type="hidden" name="selectedUserId" id="selectedUserId" value="" />
                            </div>
                        </div>
                    </div>
                    <div class="content-box-bottom-wrap">
                        <span class="middle">
                            <input type="submit" id="js__submit" class="button-global smallb type-submit button-global fixed-width-xl" value="SEND NOTIFICATION(S)">
                            <div class="button-spinner spinner-button-global" id="js__submit-spinner"></div>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
