{if $newUser} {assign var="buttonLabel" value="ADD PERSONAL CARE WORKER"} {else} {assign var="buttonLabel" value="UPDATE PERSONAL CARE WORKER"} {/if}

<div id="wrapper" class="page-wrap print opened-max">
    {include file='portalapp/administration-sidemenu.tpl' currentPage={$currentPage}}
    <div id="page-content-wrapper" class="container-fluid">
        <div class="content-area">
            <div class="navbar navbar-admin">
                <div class="left-align-b buttons-wrap">
                    <input onclick="location.href='{$URL}personalCareWorkers';"
                        type="button"
                        class="button-global smallb hollow"
                        name="button_click"
                        value="← RETURN TO PERSONAL CARE WORKERS">
                </div>
            </div>
            <div class="section-wrap">
                <div class="left-align-b buttons-wrap">
                    <button onclick="location.href='{$URL}personalCareWorkers/editUser?id={$userIdEncoded}'" type="button" class="button-global smallb">EDIT PERSONAL CARE WORKER</button>
                </div>

                <div class="table-c-wrap">
                    <table class="table-c">
                        <tr>
                            <td>Sign Up Date:</td>
                            <td>{$userData.createOn}</td>
                        </tr>
                        <tr>
                            <td>Name:</td>
                            <td>{$userData.firstName} {$userData.lastName}</td>
                        </tr>
                        <tr>
                            <td>Email Address:</td>
                            <td>{$userData.emailAddress}</td>
                        </tr>
                        <tr>
                            <td>Primary Care Person:</td>
                            <td>{$userData.primaryCarePerson}</td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td>{$userData.street}, {$userData.city}, {$userData.province} {$userData.postalCode}</td>
                        </tr>
                        <tr>
                            <td>Phone Number:</td>
                            <td>{$userData.phoneNumber}</td>
                        </tr>
                        <tr>
                            <td>Additional Phone Number:</td>
                            <td>{$userData.additionalPhoneNumber}</td>
                        </tr>
                        <tr>
                            <td>Alternate Contact:</td>
                            <td>{$userData.alternateContactName} - {$userData.alternateContactNumber}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
