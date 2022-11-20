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
                        value="← RETURN TO MEALS LIBRARY">
                </div>
            </div>
            {include file='portalapp/meals-submenu.tpl'}
            <div class="section-wrap">
                <div class="left-align-b buttons-wrap">
                    <button onclick="location.href='{$URL}meals/editImage?id={$mealItemIdEncoded}'" type="button" class="button-global smallb">EDIT IMAGE</button>
                </div>

                <div class="table-c-wrap">
                    <table class="table-c">
                        <tr>
                            <td>Thumbnail:</td>
                            <td>
                                {if $mealData.thumbnail}
                                    <img class="equipment-image-thumb" src="{$UPLOAD_FOLDER_MEDIA}meals/{$mealData.thumbnail}" /><br/>380 x 320
                                {else}
                                    No image
                                {/if}
                            </td>
                        </tr>
                        <tr>
                            <td>Image:</td>
                            <td>
                                {if $mealData.image}
                                    <img class="equipment-image-main" src="{$UPLOAD_FOLDER_MEDIA}meals/{$mealData.image}" /><br/>1080 x 1080
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
