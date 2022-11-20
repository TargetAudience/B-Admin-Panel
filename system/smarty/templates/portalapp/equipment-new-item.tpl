<div id="wrapper" class="page-wrap print opened-max">
    {include file='portalapp/administration-sidemenu.tpl'}
    <div id="page-content-wrapper" class="container-fluid">
        <div class="content-area">
            <div class="navbar navbar-admin">
                <div class="left-align-b buttons-wrap">
                    <input onclick="location.href='{$URL}equipment?type={$type}';"
                        type="button"
                        class="button-global smallb hollow"
                        name="button_click"
                        value="← RETURN TO EQUIPMENT">
                </div>
            </div>
            <div class="section-wrap nopadding">  
                <form accept-charset="UTF-8" id="js__form-equipment-new" data-src="{$URL}equipment/addUpdateItem" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="type" value="{$type}" />
                    <input type="hidden" name="formType" value="add" />
                    <div class="optional-wrap">  
                        <div class="section-input">
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Product Name <span>*</span></span></div>    
                                <input type="text" name="name" maxlength="32" value="" class="input short" />
                            </div>

                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Product Number <span>*</span></span></div>    
                                <input type="text" name="productNumber" maxlength="16" class="input extra-short" autocomplete='' />
                            </div>

                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Category <span>*</span></span></div>    
                                <select name="categoryId">
                                    <option value="">Please Select</option>
                                    {foreach from=$equipmentCategories item=category}
                                        <option value="{$category.categoryId}">{$category.name}</option>
                                    {/foreach}
                                </select>
                            </div>

                            {if $type eq 'purchase'}
                                <div class="field-set">
                                    <div class="form-label-wrap"><span class="label">Price <span>*</span></span></div>    
                                    <span class="label-price">$</span> <input type="text" name="price" maxlength="6" class="input extra-short" autocomplete='' />
                                </div>
                            {/if}

                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">In Stock <span>*</span></span></div>    
                                <input type="text" name="inStock" maxlength="3" class="input extra-short" autocomplete='' />
                            </div>

                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Delivery <span>*</span></span></div>    
                                <span class="label-price">$</span> <input type="text" name="delivery" maxlength="6" class="input extra-short" autocomplete='' />
                            </div>

                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Urgent Delivery <span>*</span></span></div>    
                                <span class="label-price">$</span> <input type="text" name="urgentDelivery" maxlength="6" class="input extra-short" autocomplete='' />
                            </div>

                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Description <span>*</span></span></div>    
                                <textarea name="description" class="text-area large"></textarea>
                            </div>

                            {if in_array('Admin', $session.role)}
                                <div class="field-set">
                                    <div class="form-label-wrap"><span class="label">Active <span>*</span></span></div>    
                                    <select name="active">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            {/if}
                        </div>
                    </div>
                    <div class="content-box-bottom-wrap">
                        <span class="middle">
                            <input type="submit" id="js__submit" class="button-global fixed-width-xsm3 smallb type-submit" value="ADD ITEM">
                            <div class="button-spinner spinner-button-global" id="js__submit-spinner"></div>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>