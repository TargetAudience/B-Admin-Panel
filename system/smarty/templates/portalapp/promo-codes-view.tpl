{if $newUser} {assign var="buttonLabel" value="ADD PROMO CODE"} {else} {assign var="buttonLabel" value="UPDATE PROMO CODE"} {/if}

<div id="wrapper" class="page-wrap print opened-max">
    {include file='portalapp/administration-sidemenu.tpl' currentPage={$currentPage}}
    <div id="page-content-wrapper" class="container-fluid">
        <div class="content-area">
            <div class="navbar navbar-admin">
                <div class="left-align-b buttons-wrap">
                    <input onclick="location.href='{$URL}promoCodes';"
                        type="button"
                        class="button-global smallb hollow"
                        name="button_click"
                        value="← RETURN TO PROMO CODES">
                </div>
            </div>
            <div class="section-wrap">
                <div class="left-align-b buttons-wrap">
                    <button onclick="location.href='{$URL}promoCodes/edit?id={$userIdEncoded}'" type="button" class="button-global smallb">EDIT PROMO CODE</button>
                </div>

                <div class="table-c-wrap">
                    <table class="table-c">
                        <tr>
                            <td>Promo Code:</td>
                            <td>{$userData.promoCode}</td>
                        </tr>
                        <tr>
                            <td>Discount:</td>
                            <td>{$userData.discount}</td>
                        </tr>
                        <tr>
                            <td>Minimum Purchase:</td>
                            <td>{$userData.minimumPurchase}</td>
                        </tr>
                        <tr>
                            <td>Specific User:</td>
                            <td>{$userData.firstName} {$userData.lastName}</td>
                        </tr>
                        <tr>
                            <td>Specific Vertical:</td>
                            <td>{$userData.specificVertical}</td>
                        </tr>
                        <tr>
                            <td>Expires On:</td>
                            <td>{$userData.expiresOn}</td>
                        </tr>
                        <tr>
                            <td>Created On:</td>
                            <td>{$userData.createdOn}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
