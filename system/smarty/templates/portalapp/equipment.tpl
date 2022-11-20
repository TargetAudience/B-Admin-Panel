<div id="wrapper" class="page-wrap print opened-max">
    {include file='portalapp/administration-sidemenu.tpl' currentPage={$currentPage}}

    <div id="page-content-wrapper" class="container-fluid">
        <div class="content-area">
            <form action="{$URL}equipment/newItem" id="checkboxForm" method="post">
                <div class="navbar navbar-admin">
                    <div class="left-align-b buttons-wrap">
                        <input type="submit" class="button-global smallb" name="button_click" value="ADD RENTAL ITEM" /> <input type="submit" class="button-global smallb" name="button_click" value="ADD PURCHASE ITEM" />
                    </div>
                </div>
                {include file='portalapp/equipment-menu.tpl' currentPage={$subPage}}
                <div class="table-b-wrap">
                    <table class="table-b pretty">
                        <thead>
                            <tr>
                                <th class="center">Active</th>
                                <th></th>
                                <th>Product Number</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                {if $type eq 'purchase'}<th>Price</th>{/if}
                                <th>In Stock</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach from=$equipmentData item=item}
                                <tr>
                                    <td class="equipment-checkmark-container">{if $item.active eq 1}<img class="equipment-checkmark" src="{$URL}assets/portalapp/images/checkmark.png" border="0" />{/if}</td>
                                    <td>
                                        {if $item.thumb}
                                            <img class="equipment-image-listing" src="{$UPLOAD_FOLDER_MEDIA}equipment/{$item.thumb}" />
                                        {/if}
                                    </td>
                                    <td>{$item.productNumber}</td>
                                    <td>{$item.name}</td>
                                    <td>{$item.categoryName}</td>
                                    {if $type eq 'purchase'}<td>${$item.price}</td>{/if}
                                    <td class="show-edit" contenteditable="true" data-id="{$item.equipmentIdEncoded}" data-type="{$type}">{$item.inStock}</td>
                                    <td><a href="{$URL}equipment/item?id={$item.equipmentIdEncoded}&type={$type}" class="view-link">View</a> <a href="#" data-src="{$URL}administration/remove?type=equipment&equipmentType={$type}&id={$item.equipmentIdEncoded}" class="js__admin-remove-item icon-spacer"><span class="icon-trash"></span></a></td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
    {include file='portalapp/users_pagination.tpl'}
</div>

{include file='portalapp/administration-popups.tpl'}

