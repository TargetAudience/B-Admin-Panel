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
            <div class="section-wrap nopadding">  
                <form accept-charset="UTF-8" id="user-form" class="form-admin" data-src="{$URL}equipment/images" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="itemId" value="{$itemIdEncoded}" />
                    <div class="left-align-indent">
                        <input onclick="location.href='{$URL}equipment/images?id={$itemIdEncoded}&type={$type}';"
                            type="button"
                            class="button-global-mini"
                            name="button_click"
                            value="← RETURN TO IMAGES">
                    </div>
                    <div class="optional-wrap">
                        <div class="section-input">
                            <div>
                                <div class="droparea" id="drop1">
                                    <span>Drag and drop thumb here</span>
                                    <img src="{$URL_ASSETS}/images/placeholder-380x320.png" class="thumb-placeholder" id="file_preview_1">
                                </div>
                                <input type="file" name="file" id="file_1" accept="image/*" style="display: none;">
                            </div>
                            <div class="second-droparea">
                                <div class="droparea" id="drop2">
                                    <span>Drag and drop main here</span>
                                    <img src="{$URL_ASSETS}/images/placeholder-998x1180.png" class="thumb-placeholder" id="file_preview_2">
                                </div>
                                <input type="file" name="file" id="file_2" accept="image/*" style="display: none;">
                            </div>   
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
window.imageId = '{$itemIdEncoded}';
window.type = '{$type}';
</script>