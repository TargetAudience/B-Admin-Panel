<div id="wrapper" class="page-wrap print opened-max">
    {include file='portalapp/administration-sidemenu.tpl'}
    <div id="page-content-wrapper" class="container-fluid">
        <div class="content-area">
            <div class="navbar navbar-admin">
                <div class="left-align-b buttons-wrap">
                    <input onclick="location.href='{$URL}meals';"
                        type="button"
                        class="button-global smallb hollow"
                        name="button_click"
                        value="← RETURN TO MEALS">
                </div>
            </div>
            {include file='portalapp/meals-submenu.tpl'}
            <div class="section-wrap nopadding">  
                <form accept-charset="UTF-8" id="js__form-meals" data-src="{$URL}meals/addUpdateItem" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="itemId" value="{$mealItemIdEncoded}" />
                    <input type="hidden" name="formType" value="edit" />
                    <div class="left-align-indent">
                        <input onclick="location.href='{$URL}meals/item?id={$mealItemIdEncoded}';"
                            type="button"
                            class="button-global-mini"
                            name="button_click"
                            value="← RETURN TO MEAL">
                    </div>
                    <div class="optional-wrap">  
                        <div class="section-input">
                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Name <span>*</span></span></div>    
                                <input type="text" name="name" maxlength="64" value="{$mealData.mealName}" class="input short" />
                            </div>

                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Category <span>*</span></span></div>    
                                <select name="categoryId">
                                    <option value="">Please Select</option>
                                    {foreach from=$mealsCategories item=category}
                                    <option value="{$category.mealCategoryId}"
                                    {if {$category.mealCategoryId} neq ''}
                                        {if $category.mealCategoryId eq {$mealData.mealCategoryId}}selected{/if}
                                    {/if}>{$category.name}</option>
                                {/foreach}
                                </select>
                            </div>

                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Price <span>*</span></span></div>    
                                <input type="text" name="price" maxlength="6" value="{$mealData.price}" class="input extra-short" autocomplete='' />
                            </div>

                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Ingredients <span>*</span></span></div>    
                                <textarea name="ingredients" class="text-area">{$mealData.ingredients}</textarea>
                            </div>

                            <div class="field-set">
                                <div class="form-label-wrap"><span class="label">Nutrition Info <span>*</span></span></div>    
                                <textarea name="nutrition" class="text-area">{$mealData.nutritionRegular}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="content-box-bottom-wrap">
                        <span class="middle">
                            <input type="submit" id="js__submit" class="button-global fixed-width-xsm2 smallb type-submit" value="UPDATE MEAL">
                            <div class="button-spinner spinner-button-global" id="js__submit-spinner"></div>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>