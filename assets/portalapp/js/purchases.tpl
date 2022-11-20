<div id="wrapper" class="page-wrap opened-max">
    {include file='portalapp/administration-sidemenu.tpl'}
    <div id="page-content-wrapper" class="container-fluid gap-top">
        <div class="content-area">
            <form accept-charset="UTF-8" action="{$URL}purchases/filter" enctype="multipart/form-data" method="post">
                <div class="section-input">
                    <div class="field-set">
                        <div class="form-label-wrap"><span class="label">Filter By Purchase Type</span></div> 
                        <select name="purchaseVerticals">
                            <option value="">Please Select</option>
                            {foreach from=$purchaseVerticals item=vertical}
                                <option value="{$vertical.vertical}"
                                {if {$currentVertical} neq ''}
                                    {if $vertical.vertical eq {$currentVertical}}selected{/if}
                                {/if}>{$vertical.verticalFriendly}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="field-set">
                    <input type="submit" class="button-global smallb type-submit fixed-width-xxl" value="FILTER">
                </div>
            </form>
            <div class="table-b-wrap">
                <table class="table-b pretty" id="sortedTable">
                    <thead>
                        <tr>
                            <th>Purchase Type</th>
                            <th>Order Id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Total Amount</th>
                            <th>Purchase Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$userData item=user}
                            <tr>
                                <td>{$user.verticalFriendly}</td>
                                <td>{$user.customerOrderId}</td>
                                <td>{$user.firstName}</td>
                                <td>{$user.lastName}</td>
                                <td>${$user.total}</td>
                                <td>{$user.dateCreated}</td>
                                <td><a href="{$URL}purchases/details?id={$user.purchaseIdEncoded}" class="view-link">View</a> <a href="#" data-src="{$URL}administration/remove?type=purchases&id={$user.purchaseid}" class="js__admin-remove-item icon-spacer"><span class="icon-trash"></span></a></td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {include file='portalapp/users_pagination.tpl'}
</div>

{include file='portalapp/administration-popups.tpl'}