{if $newUser} {assign var="buttonLabel" value="ADD USER"} {else} {assign var="buttonLabel" value="UPDATE USER"} {/if}

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
                <div class="left-align-b buttons-wrap">
                    <button onclick="location.href='{$URL}users/editStats?id={$userIdEncoded}'" type="button" class="button-global smallb">EDIT STATS</button>
                </div>
                <div class="table-c-wrap">
                    <table class="table-c">
                        <tr>
                            <td>Total Earnings:</td>
                            <td>${$userData.earnings}</td>
                        </tr>
                        <tr>
                            <td>Balance:</td>
                            <td>${$userData.balance}</td>
                        </tr>
                        <tr>
                            <td>Incoming Calls:</td>
                            <td>{$userData.incoming_call_count}</td>
                        </tr>
                        <tr>
                            <td>Outgoing Calls:</td>
                            <td>{$userData.outgoing_call_count}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
