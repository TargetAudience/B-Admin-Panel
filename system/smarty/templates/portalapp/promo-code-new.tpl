<div id="wrapper" class="page-wrap print opened-max">
    {include file='portalapp/administration-sidemenu.tpl'}
    <div id="page-content-wrapper" class="container-fluid">
        <div class="content-area">
            <div class="navbar navbar-admin">
                <div class="left-align-b buttons-wrap">
                    <input onclick="location.href='{$URL}promoCodes';"
                        type="button"
                        class="button-global smallb hollow"
                        name="button_click"
                        value="← RETURN TO PROMO CODES">
                </div>
            </div>
            <div class="section-wrap nopadding">  
                <form accept-charset="UTF-8" id="js__form-promo-code" data-src="{$URL}promoCodes/add" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="formType" value="add" />
                    <div class="optional-wrap">  
                        <div class="section-input">
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Promo Code <span>*</span></span></div>
                                <input type="text" name="promoCode" maxlength="64" value="" class="input short" autocomplete='given-name' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Discount <span>*</span></span></div>
                                <input type="text" name="discount" maxlength="64" value="" class="input short" autocomplete='family-name' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Minimum Purchase <span>*</span></span></div>
                                <input type="text" name="minimumPurchase" maxlength="64" value="" class="input short" autocomplete='family-name' />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Specific User </span></div>
                                <input type="text" id="userAutoComplete" name="userAutoComplete" maxlength="64" value="" class="input short" autocomplete='family-name' />
                                <input type="hidden" name="specificUserId" id="specificUserId" value="" />
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Specific Vertical </span></div>
                                <select name="specificVertical">
                                    <option value="">Please Select</option>
                                    {foreach from=$verticals item=vertical}
                                        <option value="{$vertical.vertical}">{$vertical.verticalFriendly}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Expires On <span>*</span></span></div>
                                <input type="date" name="expiresOn" maxlength="64" value="" class="input short" autocomplete='family-name' />
                            </div>
                        </div>
                    </div>
                    <div class="content-box-bottom-wrap">
                        <span class="middle">
                            <input type="submit" id="js__submit" class="button-global smallb type-submit fixed-width-xxl" value="ADD PROMO CODE">
                            <div class="button-spinner spinner-button-global" id="js__submit-spinner"></div>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>