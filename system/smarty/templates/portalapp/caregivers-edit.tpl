{if $newUser}
    {assign var="buttonLabel" value="ADD CAREGIVER"}
{else}
    {assign var="buttonLabel" value="UPDATE CAREGIVER"}
{/if}

<div id="wrapper" class="page-wrap print opened-max">
    {include file='portalapp/administration-sidemenu.tpl' currentPage={$currentPage}}
    <div id="page-content-wrapper" class="container-fluid">
        <div class="content-area">
            <div class="navbar navbar-admin">
                <div class="left-align-b buttons-wrap">
                    <input onclick="location.href='{$URL}caregivers';" type="button" class="button-global smallb hollow" name="button_click" value="&larr; RETURN TO CAREGIVERS" />
                </div>
            </div>
            <div class="section-wrap nopadding">
                <form accept-charset="UTF-8" id="js__caregivers-edit" class="form-admin" data-src="{$URL}caregivers/createUpdateUser" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="userId" id="js__caregivers-edit-userid" value="{$userIdEncoded}" />
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
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Primary Care Person <span>*</span></span></div>
                                <select name="accountHolder">
                                    <option value="">Please Select</option>
                                    <option value="0" {if $userData.accountHolder eq {0}}selected{/if}>No</option>
                                    <option value="1" {if $userData.accountHolder eq {1}}selected{/if}>Yes</option>
                                </select>
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Address <span>*</span></span></div>
                                <input type="text" name="street" maxlength="64" value="{$userData.street}" class="input short" autocomplete='' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">City <span>*</span></span></div>
                                <input type="text" name="city" maxlength="64" value="{$userData.city}" class="input short" autocomplete='' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Province <span>*</span></span></div>
                                <select name="province">
                                    <option value="">Please Select</option>
                                    <option value="AB" {if $userData.province eq {"AB"}}selected{/if}>Alberta</option>
                                    <option value="BC" {if $userData.province eq {"BC"}}selected{/if}>British Columbia</option>
                                    <option value="MB" {if $userData.province eq {"MB"}}selected{/if}>Manitoba</option>
                                    <option value="NB" {if $userData.province eq {"NB"}}selected{/if}>New Brunswick</option>
                                    <option value="NL" {if $userData.province eq {"NL"}}selected{/if}>Newfoundland and Labrador</option>
                                    <option value="NT" {if $userData.province eq {"NT"}}selected{/if}>Northwest Territories</option>
                                    <option value="NS" {if $userData.province eq {"NS"}}selected{/if}>Nova Scotia</option>
                                    <option value="NU" {if $userData.province eq {"NU"}}selected{/if}>Nunavut</option>
                                    <option value="ON" {if $userData.province eq {"ON"}}selected{/if}>Ontario</option>
                                    <option value="PE" {if $userData.province eq {"PE"}}selected{/if}>Prince Edward Island</option>
                                    <option value="QC" {if $userData.province eq {"QC"}}selected{/if}>Quebec</option>
                                    <option value="SK" {if $userData.province eq {"SK"}}selected{/if}>Saskatchewan</option>
                                    <option value="YT" {if $userData.province eq {"YT"}}selected{/if}>Yukon Territory</option>
                                </select>
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Postal Code <span>*</span></span></div>
                                <input type="text" name="postalCode" maxlength="64" value="{$userData.postalCode}" class="input short" autocomplete='' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Phone Number <span>*</span></span></div>
                                <input type="text" name="phoneNumber" maxlength="64" value="{$userData.phoneNumber}" class="input short" autocomplete='' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Additional Phone Number </span></div>
                                <input type="text" name="additionalPhoneNumber" maxlength="64" value="{$userData.additionalPhoneNumber}" class="input short" autocomplete='' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Alternate Contact Name </span></div>
                                <input type="text" name="alternateContactName" maxlength="64" value="{$userData.alternateContactName}" class="input short" autocomplete='' />
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
