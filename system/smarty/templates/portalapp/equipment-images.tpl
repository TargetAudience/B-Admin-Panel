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
            <div class="section-wrap">
                <div class="left-align-b buttons-wrap">
                    <button onclick="location.href='{$URL}equipment/editImages?id={$itemIdEncoded}&type={$type}'" type="button" class="button-global smallb">EDIT IMAGES</button>
                </div>

                <div class="table-c-wrap">
                    <table class="table-c">
                        <tr>
                            <td>Thumbnail:</td>
                            <td>
                                {if $equipmentData.thumb}
                                    <img class="equipment-image-thumb" src="{$UPLOAD_FOLDER_MEDIA}equipment/{$equipmentData.thumb}" /><br/>380 x 320
                                {else}
                                    No image
                                {/if}
                            </td>
                        </tr>
                        <tr>
                            <td>Main:</td>
                            <td>
                                {if $equipmentData.thumb}
                                    <img class="equipment-image-main" src="{$UPLOAD_FOLDER_MEDIA}equipment/{$equipmentData.featureImage}" /><br/>998 x 1180
                                {else}
                                    No image
                                {/if}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
