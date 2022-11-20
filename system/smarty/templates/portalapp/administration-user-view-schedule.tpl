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
                    <button onclick="location.href='{$URL}users/editSchedule?id={$userIdEncoded}'" type="button" class="button-global smallb">EDIT SCHEDULE</button>
                </div>
                <div class="table-c-wrap">
                    <table class="table-c">
                        <thead>
                            <tr>
                                <th>Day</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                            </tr> 
                        </thead>
                        <tbody>
                            {foreach from=$scheduleData item=item}
                                <tr>
                                    <td>{$item.day}</td>
                                    <td>{$item.start_time}</td>
                                    <td>{$item.end_time}</td>
                                </tr>    
                            {/foreach}
                        <tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
