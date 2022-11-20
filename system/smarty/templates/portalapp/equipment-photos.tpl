{if $newUser} {assign var="buttonLabel" value="ADD USER"} {else} {assign var="buttonLabel" value="UPDATE USER"} {/if}

<div id="wrapper" class="page-wrap print opened-max">
    {include file='portalapp/administration-sidemenu.tpl' currentPage={$currentPage}}
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
            {include file='portalapp/equipment-submenu.tpl' currentPage={$subPage} userId={$userIdEncoded}}
            <div class="section-wrap">
                <div class="left-align-b buttons-wrap">
                    <button onclick="location.href='{$URL}users/editUser?id={$userIdEncoded}'" type="button" class="button-global smallb">EDIT DETAILS</button>
                </div>

                <div class="table-c-wrap">
                    <table class="table-c">
                        <td><img class="equipment-image" src="{$UPLOAD_FOLDER}equipment/{$equipmentData.thumb}" /></td>
                        <tr>
                            <td>Product Name:</td>
                            <td>{$equipmentData.name}</td>
                        </tr>
                        <tr>
                            <td>Category:</td>
                            <td>{$equipmentData.categoryName}</td>
                        </tr>
                        <tr>
                            <td>In Stock:</td>
                            <td>{$equipmentData.inStock}</td>
                        </tr>
                        <tr>
                            <td>Delivery Price:</td>
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
                            <td>Added On:</td>
                            <td>{$equipmentData.createOn}</td>
                        </tr>
                        <tr>
                            <td>Last Updated:</td>
                            <td>{$equipmentData.lastUpdate}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
