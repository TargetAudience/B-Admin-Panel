{if $newUser} {assign var="buttonLabel" value="ADD USER"} {else} {assign var="buttonLabel" value="UPDATE USER"} {/if}

<div id="wrapper" class="page-wrap print opened-max">
    {include file='portalapp/administration-sidemenu.tpl' currentPage={$currentPage}}
    <div id="page-content-wrapper" class="container-fluid">
        <div class="content-area">
            <div class="navbar navbar-admin">
                <div class="left-align-b buttons-wrap">
                    <input onclick="location.href='{$URL}adminUsers';"
                        type="button"
                        class="button-global smallb hollow"
                        name="button_click"
                        value="← RETURN TO USERS">
                </div>
            </div>
            <div class="section-wrap">
                <div class="left-align-b buttons-wrap">
                    <button onclick="location.href='{$URL}adminUsers/editUser?id={$userIdEncoded}'" type="button" class="button-global smallb">EDIT USER</button>
                </div>

                <div class="table-c-wrap">
                    <table class="table-c">
                        <tr>
                            <td>Sign Up Date:</td>
                            <td>{$userData.dateCreated}</td>
                        </tr>
                        <tr>
                            <td>Last Login:</td>
                            <td>{$userData.lastLogin}</td>
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
                            <td>Role:</td>
                            <td>{$userData.role}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
