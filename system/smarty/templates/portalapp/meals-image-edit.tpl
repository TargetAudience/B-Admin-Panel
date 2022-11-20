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
            <div class="section-wrap nopadding">  
                <form accept-charset="UTF-8" id="user-form" class="form-admin" data-src="{$URL}meals/image" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="itemId" value="{$mealItemIdEncoded}" />
                    <div class="left-align-indent">
                        <input onclick="location.href='{$URL}meals/image?id={$mealItemIdEncoded}';"
                            type="button"
                            class="button-global-mini"
                            name="button_click"
                            value="← RETURN TO IMAGE">
                    </div>
                    <div class="optional-wrap">
                        <div class="section-input">
                            <div>
                                <div class="droparea" id="drop4">
                                    <span>Drag and drop thumb here</span>
                                    <img src="{$URL_ASSETS}/images/placeholder-380x320.png" class="thumb-placeholder" id="file_preview_4">
                                </div>
                                <input type="file" name="file" id="file_4" accept="image/*" style="display: none;">
                            </div>
                            <div class="second-droparea">
                                <div class="droparea" id="drop3">
                                    <span>Drag and drop thumb here</span>
                                    <img src="{$URL_ASSETS}/images/placeholder-1080x1080.png" class="thumb-placeholder" id="file_preview_3">
                                </div>
                                <input type="file" name="file" id="file_3" accept="image/*" style="display: none;">
                            </div> 
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
window.imageMealItemId = '{$mealItemIdEncoded}';
</script>