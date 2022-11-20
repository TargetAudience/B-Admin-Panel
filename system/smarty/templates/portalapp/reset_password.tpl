{assign var="buttonLabel" value="UPDATE PASSWORD"}

<div id="wrapper" class="page-wrap print opened-max">
    {include file='portalapp/administration-sidemenu.tpl' currentPage={$currentPage}}
    <div id="page-content-wrapper" class="container-fluid">
        <div class="content-area">
            {include file='portalapp/myaccount_submenu.tpl' currentPage={$subPage}}
            <div class="section-wrap nopadding">  
                <form accept-charset="UTF-8" id="js__profile-admin-password-edit" class="form-admin" data-src="{$URL}myaccount/updatePassword" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="userId" id="js__profile-edit-userid" value="{$userIdEncoded}" />
                    <div class="optional-wrap">  
                        <div class="section-input">
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Current Password</span></div>    
                                <input type="password" name="currentPassword" maxlength="32" class="input short" autocomplete='' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">New Password</span></div>    
                                <input type="password" name="newPassword" maxlength="32" class="input short" autocomplete='' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Confirm New Password</span></div>    
                                <input type="password" name="confirmPassword" maxlength="32" class="input short" autocomplete='' />
                            </div>
                        </div>
                    </div>
                    <div class="content-box-bottom-wrap">
                        <span class="middle">
                            <input type="submit" id="js__submit" class="button-global smallb type-submit" value="{$buttonLabel}">
                            <div class="button-spinner spinner-button-global" id="js__submit-spinner"></div>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


