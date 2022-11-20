<div id="wrapper" class="page-wrap print opened-max">
    {include file='portalapp/administration-sidemenu.tpl'}
    <div id="page-content-wrapper" class="container-fluid">
        <div class="content-area">
            <div class="navbar navbar-admin">
                <div class="left-align-b buttons-wrap">
                    <input onclick="location.href='{$URL}equipment';"
                        type="button"
                        class="button-global smallb hollow"
                        name="button_click"
                        value="← RETURN TO EQUIPMENT">
                </div>
            </div>
            {include file='portalapp/equipment-submenu.tpl'}
            <div class="section-wrap nopadding">  
                <form accept-charset="UTF-8" id="js__form-equipment-pricing" class="form-admin" data-src="{$URL}equipment/editPricing2" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="itemId" value="{$itemIdEncoded}" />
                    <input type="hidden" name="count" value="{$count}" />
                    <input type="hidden" name="type" value="{$type}" />
                    <div class="left-align-indent">
                        <input onclick="location.href='{$URL}equipment/pricing?id={$itemIdEncoded}&type={$type}';"
                            type="button"
                            class="button-global-mini"
                            name="button_click"
                            value="← RETURN TO PRICING">
                    </div>
                    <div class="optional-wrap">  
                        <div class="section-input">
                            <table class="table-b">
                                {assign var=runningCount value=0}
                                {foreach from=$options item=option} 
                                    <tr>
                                        <td>
                                            <div class="field-set inline">
                                                <div class="form-label-wrap"><span class="label">Duration </span></div>    
                                                <input type="text" name="duration[{$runningCount}]" maxlength="32" value="{$option.duration}" class="input short" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="field-set inline">
                                                <div class="form-label-wrap"><span class="label">Price </span></div>    
                                                <input type="text" name="price[{$runningCount}]" maxlength="6" value="{$option.price}" class="input extra-short" />
                                            </div>
                                        </td>
                                        {if in_array('Admin', $session.role)}
                                            <td>
                                                <div class="field-set inline">
                                                    <div class="form-label-wrap"><span class="label">Order </span></div>    
                                                    <select name="priority[{$runningCount}]" class="form-select-short">
                                                        {foreach from=$order item=orderItem name=count}
                                                            <option value="{$orderItem}" {if $orderItem eq $option.priority}selected{/if}>{$orderItem}</option>
                                                        {/foreach}
                                                    </select>
                                                </div>
                                            </td>
                                        {/if}
                                    </tr>
                                    {assign var=runningCount value=$runningCount+1}
                                {/foreach}
                                {assign var=runningCount2 value=0}
                                {foreach from=$extras item=extra}
                                    <tr>
                                        <td>
                                            <div class="field-set inline">
                                                <div class="form-label-wrap"><span class="label">Duration </span></div>    
                                                <input type="text" name="durationAdd[{$runningCount2}]" maxlength="32" value="" class="input short" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="field-set inline">
                                                <div class="form-label-wrap"><span class="label">Price </span></div>    
                                                <input type="text" name="priceAdd[{$runningCount2}]" maxlength="6" value="" class="input extra-short" />
                                            </div>
                                        </td>
                                        {if in_array('Admin', $session.role)}
                                            <td>
                                                <div class="field-set inline">
                                                    <div class="form-label-wrap"><span class="label">Order </span></div>    
                                                    <select name="priorityAdd[{$runningCount2}]" class="form-select-short">
                                                        {foreach from=$order item=orderItem name=count}
                                                            <option value="{$orderItem}">{$orderItem}</option>
                                                        {/foreach}
                                                    </select>
                                                </div>
                                            </td>
                                        {/if}
                                    </tr>
                                    {assign var=runningCount2 value=$runningCount2+1}
                                {/foreach}
                            </table>
                        </div>
                    </div>
                    <div class="content-box-bottom-wrap">
                        <span class="middle">
                            <input type="submit" id="js__submit" class="button-global fixed-width-xsm smallb type-submit" value="UPDATE PRICING">
                            <div class="button-spinner spinner-button-global" id="js__submit-spinner"></div>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>