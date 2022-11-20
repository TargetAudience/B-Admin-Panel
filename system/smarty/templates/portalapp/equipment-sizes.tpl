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
                    <button onclick="location.href='{$URL}equipment/editSizes?id={$itemIdEncoded}&type={$type}'" type="button" class="button-global smallb">EDIT SIZES</button>
                </div>

                <table class="table-b gap-top">
                    <thead>
                        <tr>
                            <th>Size</th>
                            {if in_array('Admin', $session.role)}<th>Order</th>{/if}
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$options item=option}
                            <tr>
                                <td>{$option.size}</td>
                                {if in_array('Admin', $session.role)}<td>{$option.priority}</td>{/if}
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
