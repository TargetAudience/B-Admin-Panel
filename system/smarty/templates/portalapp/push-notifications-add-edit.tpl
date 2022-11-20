{if $formType eq 'add'}
    {assign var="buttonLabel" value="ADD PUSH NOTIFICATION"}
{else}
    {assign var="buttonLabel" value="UPDATE NOTIFICATION"}
{/if}

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
                <form accept-charset="UTF-8" id="js__user-admin-add" class="form-admin" data-src="{$URL}pushNotifications/addEditUser" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="notificationsIdEncoded" value="{$notificationsIdEncoded}" />
                    <input type="hidden" name="formType" value="{$formType}" />
                    <div class="left-align-indent">
                        <input onclick="location.href='{$URL}pushNotifications/notificationView?id={$notificationsIdEncoded}';"
                            type="button"
                            class="button-global-mini"
                            name="button_click"
                            value="← RETURN TO DETAILS">
                    </div>
                    <div class="optional-wrap">
                        <div class="section-input">
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Internal Name <span>*</span></span></div>
                                <input type="text" name="internalName" maxlength="64" class="input short" value="{$notificationData.internalName}" />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Message Title</span></div>
                                <input type="text" name="messageTitle" maxlength="38" class="input short" value="{$notificationData.messageTitle}" />
                                <div class="instructions gap">Max. 38 Characters</div>
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Message <span>*</span></span></div>    
                                <textarea name="messageBody" class="text-area">{$notificationData.messageBody}</textarea>
                                <div class="instructions">Max. 150 Characters</div>
                            </div>
                        </div>
                    </div>
                    <div class="content-box-bottom-wrap">
                        <span class="middle">
                            <input type="submit" id="js__submit" class="button-global smallb type-submit button-global fixed-width-xl" value="{$buttonLabel}">
                            <div class="button-spinner spinner-button-global" id="js__submit-spinner"></div>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
