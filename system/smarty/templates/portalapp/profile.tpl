{assign var="buttonLabel" value="UPDATE PROFILE"}

<div id="wrapper" class="page-wrap print">
    <div id="page-content-wrapper" class="container-fluid bottom-padding-15">
        <div class="">
            <div class="section-wrap nopadding">  
                <form accept-charset="UTF-8" id="profile-form" class="form-admin" data-src="{$URL}profile/createUpdateProfile" enctype="multipart/form-data" method="post">
                    <div class="optional-wrap">  
                        <div class="section-input">
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Name</span></div>    
                                <input type="text" name="" maxlength="64" value="{$userData.firstName} {$userData.lastName}" class="input short" autocomplete='' disabled />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">E-Mail Address</span></div>    
                                <input type="text" name="" maxlength="64" value="{$userData.emailAddress}" class="input short" autocomplete='' disabled />
                            </div>
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
                            <input type="submit" id="js__submit" class="button-global smallb type-submit fixed-width-xsm" value="{$buttonLabel}">
                            <div class="button-spinner spinner-button-global" id="js__submit-spinner"></div>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


