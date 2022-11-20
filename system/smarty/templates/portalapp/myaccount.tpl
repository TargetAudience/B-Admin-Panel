<div id="wrapper" class="page-wrap print opened-max">
    {include file='portalapp/administration-sidemenu.tpl' currentPage={$currentPage}}
    <div id="page-content-wrapper" class="container-fluid">
        <div class="content-area">
            {include file='portalapp/myaccount_submenu.tpl' currentPage={$subPage}}
            <div class="section-wrap nopadding">
                <form accept-charset="UTF-8" id="js__profile-admin-edit" class="form-admin" data-src="{$URL}myaccount/update" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="userId" id="js__profile-edit-userid" value="{$userIdEncoded}" />
                    <input type="hidden" name="type" id="js__profile-edit-userid" value="{$type}" />
                    <div class="optional-wrap">
                        <div class="section-input">
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">First Name <span>*</span></span></div>
                                <input type="text" name="firstName" maxlength="64" value="{$userData.firstName}" class="input short" autocomplete='given-name' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Last Name</span></div>
                                <input type="text" name="lastName" maxlength="64" value="{$userData.lastName}" class="input short" autocomplete='family-name' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">E-mail Address <span>*</span></span></div>
                                <input type="text" name="emailAddress" maxlength="64" value="{$userData.emailAddress}" class="input short" autocomplete='' />
                            </div>
                        </div>
                    </div>
                    <div class="content-box-bottom-wrap">
                        <span class="middle">
                            <input type="submit" id="js__submit" class="button-global smallb type-submit" value="SAVE PROFILE">
                            <div class="button-spinner spinner-button-global" id="js__submit-spinner"></div>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>