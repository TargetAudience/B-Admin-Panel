{if $newUser}
    {assign var="buttonLabel" value="ADD USER"}
{else}
    {assign var="buttonLabel" value="UPDATE USER"}
{/if}

<div id="wrapper" class="page-wrap print opened-max">
    {include file='portalapp/administration-sidemenu.tpl' currentPage={$currentPage}}
    <div id="page-content-wrapper" class="container-fluid">
        <div class="content-area">
            <div class="navbar navbar-admin">
                <div class="left-align-b buttons-wrap">
                    <input onclick="location.href='{$URL}adminUsers';" type="button" class="button-global smallb hollow" name="button_click" value="&larr; RETURN TO USERS" />
                </div>
            </div>

            <div class="section-wrap nopadding">
                <form accept-charset="UTF-8" id="js__user-admin-add" class="form-admin" data-src="{$URL}adminUsers/insertUser" enctype="multipart/form-data" method="post">
                    <div class="optional-wrap">
                        <div class="section-input">
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">First Name <span>*</span></span></div>
                                <input type="text" name="firstName" maxlength="64" class="input short" autocomplete='given-name' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Last Name</span></div>
                                <input type="text" name="lastName" maxlength="64" class="input short" autocomplete='family-name' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">E-mail Address <span>*</span></span></div>
                                <input type="text" name="emailAddress" maxlength="64" class="input short" autocomplete='' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Role <span>*</span></span></div>    
                                <select name="role[]" multiple size="5" style="height: 100%">
                                    <option value="">Please Select</option>
                                    {foreach from=$adminRoles item=role}
                                    <option value="{$role.id}"
                                    >{$role.name}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Password </span></div>
                                <input type="password" name="password" maxlength="64" class="input short" autocomplete='off' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Confirm Password </span></div>
                                <input type="password" name="confirmpassword" maxlength="64" class="input short" autocomplete='' />
                            </div>
                        </div>
                    </div>
                    <div class="content-box-bottom-wrap">
                        <span class="middle">
                            <input type="submit" id="js__submit" class="button-global smallb type-submit fixed-width-xsm2" value="{$buttonLabel}">
                            <div class="button-spinner spinner-button-global" id="js__submit-spinner"></div>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
