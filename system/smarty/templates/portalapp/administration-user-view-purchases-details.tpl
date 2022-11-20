{if $newUser} {assign var="buttonLabel" value="ADD PURCHASE"} {else} {assign var="buttonLabel" value="UPDATE PURCHASE"} {/if}

<div id="wrapper" class="page-wrap print opened-max">
    {include file='portalapp/administration-sidemenu.tpl' currentPage={$currentPage}}
    <div id="page-content-wrapper" class="container-fluid">
        <div class="content-area">
            <div class="navbar navbar-admin">
                <div class="left-align-b buttons-wrap">
                    <input onclick="location.href='{$URL}users/usersPurchases?id={$userIdEncoded}';"
                        type="button"
                        class="button-global smallb hollow"
                        name="button_click"
                        value="← RETURN TO USERS PURCHASES">
                </div>
            </div>
            <div class="section-wrap">
                <div class="table-c-wrap left">
                    <table class="table-c left">
                        <tr>
                            <td>Purchase Name:</td>
                            <td>{$userData.purchaseName}</td>
                        </tr>
                        <tr>
                            <td>First Name:</td>
                            <td>{$userData.firstName}</td>
                        </tr>
                        <tr>
                            <td>Last Name:</td>
                            <td>{$userData.lastName}</td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td>{$userData.street}</td>
                        </tr>
                        <tr>
                            <td>City:</td>
                            <td>{$userData.city}</td>
                        </tr>
                        <tr>
                            <td>Province:</td>
                            <td>{$userData.province}</td>
                        </tr>
                        <tr>
                            <td>Postal Code:</td>
                            <td>{$userData.postalCode}</td>
                        </tr>
                        <tr>
                            <td>Phone Number:</td>
                            <td>{$userData.phoneNumber}</td>
                        </tr>
                    </table>
                    <table class="table-c left">
                        <tr>
                            <td>Order Id:</td>
                            <td>{$userData.customerOrderId}</td>
                        </tr>
                        <tr>
                            <td>Purchase Type:</td>
                            <td>{$userData.verticalFriendly}</td>
                        </tr>
                        <tr>
                            <td>Total Amount:</td>
                            <td>${$userData.total}</td>
                        </tr>
                        <tr>
                            <td>Taxes:</td>
                            <td>${$userData.tax}</td>
                        </tr>
                        <tr>
                            <td>Credit Card:</td>
                            <td>{$userData.cardType}</td>
                        </tr>
                        <tr>
                            <td>Promo Code:</td>
                            <td>{$userData.promoCode}</td>
                        </tr>
                        <tr>
                            <td>Quantity:</td>
                            <td>{$userData.quantityOfItems}</td>
                        </tr>
                        <tr>
                            <td>Purchase Date:</td>
                            <td>{$userData.dateCreated}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
