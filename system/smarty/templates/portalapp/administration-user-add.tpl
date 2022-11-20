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
                    <input onclick="location.href='{$URL}users';" type="button" class="button-global smallb hollow" name="button_click" value="&larr; RETURN TO USERS" />
                </div>
            </div>

            <div class="section-wrap nopadding">
                <form accept-charset="UTF-8" id="js__user-add" class="form-admin" data-src="{$URL}users/insertUser" enctype="multipart/form-data" method="post">
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
                                <div class="form-label-wrap"><span class="label">Primary Care Person <span>*</span></span></div>
                                <select name="accountHolder">
                                    <option value="">Please Select</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Address <span>*</span></span></div>
                                <input type="text" name="street" maxlength="64" class="input short" autocomplete='' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">City <span>*</span></span></div>
                                <input type="text" name="city" maxlength="64" class="input short" autocomplete='' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Province <span>*</span></span></div>
                                <select name="province">
                                    <option value="">Please Select</option>
                                    <option value="AB">Alberta</option>
                                    <option value="BC">British Columbia</option>
                                    <option value="MB">Manitoba</option>
                                    <option value="NB">New Brunswick</option>
                                    <option value="NL">Newfoundland and Labrador</option>
                                    <option value="NT">Northwest Territories</option>
                                    <option value="NS">Nova Scotia</option>
                                    <option value="NU">Nunavut</option>
                                    <option value="ON">Ontario</option>
                                    <option value="PE">Prince Edward Island</option>
                                    <option value="QC">Quebec</option>
                                    <option value="SK">Saskatchewan</option>
                                    <option value="YT">Yukon Territory</option>
                                </select>
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Postal Code <span>*</span></span></div>
                                <input type="text" name="postalCode" maxlength="64" class="input short" autocomplete='' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Phone Number <span>*</span></span></div>
                                <input type="text" name="phoneNumber" maxlength="64" class="input short" autocomplete='' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Additional Phone Number </span></div>
                                <input type="text" name="additionalPhoneNumber" maxlength="64" class="input short" autocomplete='' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Alternate Contact Name </span></div>
                                <input type="text" name="alternateContactName" maxlength="64" class="input short" autocomplete='' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Password </span></div>
                                <input type="password" name="password" maxlength="64" class="input short" autocomplete='' />
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
