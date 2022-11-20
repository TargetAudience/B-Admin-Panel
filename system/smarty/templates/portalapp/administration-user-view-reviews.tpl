<div id="wrapper" class="page-wrap print opened-max">
    {include file='portalapp/administration-sidemenu.tpl' currentPage={$currentPage}}
    <div id="page-content-wrapper" class="container-fluid">
        <div class="content-area">
            <div class="navbar navbar-admin">
                <div class="left-align-b buttons-wrap">
                    <input onclick="location.href='{$URL}users';"
                        type="button"
                        class="button-global smallb hollow"
                        name="button_click"
                        value="← RETURN TO USERS">
                </div>
            </div>
            {include file='portalapp/administration-submenu.tpl' currentPage={$subPage} userId={$userIdEncoded}}
            <div class="section-wrap">
                <div class="table-b-wrap">
                    <table class="table-b pretty">
                        <thead>
                            <tr>
                                <th>Buyer Name</th>
                                <th>Call Id</th>
                                <th>Price / Min</th>
                                <th>Review Rating</th>
                                <th>Review Note</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach from=$userData item=user}
                                <tr>
                                    <td>{$user.personName}</td>
                                    <td>{$user.call_id}</td>
                                    <td>${$user.price}</td>
                                    <td>{$user.rating}</td>
                                    <td>{$user.note}</td>
                                    <td>{$user.createdon}</td>
                                    <td><a href="{$URL}users/editReview?id={$userIdEncoded}&review_id={$user.ratingIdEncoded}" class="view-link">Edit</a> <a href="#" data-src="{$URL}administration/remove?type=userReview&id={$userIdEncoded}&review_id={$user.ratingIdEncoded}" class="js__admin-remove-item icon-spacer"><span class="icon-trash"></span></a></td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{include file='portalapp/administration-popups.tpl'}