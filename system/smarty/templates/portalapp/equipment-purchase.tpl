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
                                <th></th>
                                <th>Category</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>In Stock</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach from=$equipmentData item=item}
                                <tr>
                                    <td><img class="equipment-image-listing" src="{$UPLOAD_FOLDER}equipment/{$item.thumb}" /></td>
                                    <td>{$item.categoryName}</td>
                                    <td>{$item.name}</td>
                                    <td>${$item.price}</td>
                                    <td class="show-edit" contenteditable="true" data-id="{$item.equipmentIdEncoded}" data-type="purchase">{$item.inStock}</td>
                                    <td><a href="{$URL}equipment/item?id={$item.equipmentIdEncoded}&type=purchase" class="view-link">View</a> <a href="#" data-src="{$URL}administration/remove?type=equipment&id={$item.equipmentIdEncoded}" class="js__admin-remove-item icon-spacer"><span class="icon-trash"></span></a></td>
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
