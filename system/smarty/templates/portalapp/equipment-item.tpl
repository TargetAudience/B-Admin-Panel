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
            {include file='portalapp/equipment-submenu.tpl'}
            <div class="section-wrap">
                <div class="left-align-b buttons-wrap">
                    <button onclick="location.href='{$URL}equipment/editItem?id={$itemIdEncoded}&type={$type}'" type="button" class="button-global smallb">EDIT DETAILS</button>
                </div>

                <div class="table-c-wrap">
                    <table class="table-c">
                        {if $equipmentData.thumb}
                            <tr>
                                <td><img class="equipment-image" src="{$UPLOAD_FOLDER_MEDIA}equipment/{$equipmentData.thumb}" /></td>
                            </tr>
                        {/if}
                        <tr>
                            <td>Product Name:</td>
                            <td>{$equipmentData.name}</td>
                        </tr>
                        <tr>
                            <td>Product Number:</td>
                            <td>{$equipmentData.productNumber}</td>
                        </tr>
                        <tr>
                            <td>Category:</td>
                            <td>{$equipmentData.categoryName}</td>
                        </tr>
                        {if $type eq 'purchase'}
                            <tr>
                                <td>Price:</td>
                                <td>${$equipmentData.price}</td>
                            </tr>
                        {/if}
                        <tr>
                            <td>In Stock:</td>
                            <td>{$equipmentData.inStock}</td>
                        </tr>
                        <tr>
                            <td>Delivery:</td>
                            <td>${$equipmentData.delivery}</td>
                        </tr>
                        <tr>
                            <td>Urgent Delivery:</td>
                            <td>${$equipmentData.rushDelivery}</td>
                        </tr>
                        <tr>
                            <td>Description:</td>
                            <td>{$equipmentData.description}</td>
                        </tr>
                        <tr>
                            <td>Active:</td>
                            <td>{if $equipmentData.active eq 1}Yes{else}No{/if}</td>
                        </tr>
                        <tr>
                            <td>Updated:</td>
                            <td>{$equipmentData.lastUpdate}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
