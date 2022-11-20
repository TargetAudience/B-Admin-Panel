 <div id="wrapper" class="page-wrap print opened-max">
    {include file='portalapp/administration-sidemenu.tpl' currentPage={$currentPage}}

    <div id="page-content-wrapper" class="container-fluid">
        <div class="content-area">
        <form accept-charset="UTF-8" id="js__form-meals-add-to-week" data-src="{$URL}meals/addMealsToWeek2" enctype="multipart/form-data" method="post">
            <form action="{$URL}meals/addMealsToWeek2" method="post">
                <input type="hidden" name="weekUrlParam" value="{$weekUrlParam}" />
                <input type="hidden" name="weekName" value="{$weekDisplay} to {$endDisplay}" />

                <div class="navbar navbar-admin">
                    <div class="left-align-b buttons-wrap">
                        <input onclick="location.href='{$URL}meals/calendar';"
                            type="button"
                            class="button-global smallb hollow"
                            name="button_click"
                            value="← RETURN TO CALENDAR">
                    </div>
                </div>

                <div class="sub-menu">
                    <span class="date-heading">{$weekDisplay} to {$endDisplay}</span>
                </div>

                <div class="table-b-wrap">
                    <table class="table-b pretty table-layout">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach from=$mealsData item=item}
                                <tr>
                                    <td class="center">
                                        <input class="box" type="checkbox" name="meal[]" value="{$item.mealItemIdEncoded}" />
                                    </td>
                                    <td>
                                        {if $item.thumbnail}
                                            <img class="meals-image-listing" src="{$UPLOAD_FOLDER_MEDIA}meals/{$item.thumbnail}" />
                                        {/if}
                                    </td>
                                    <td>{$item.mealName}</td>
                                    <td>{$item.categoryName}</td>
                                    <td>${$item.price}</td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>
                              
                <div class="gap-top">
                    <input type="submit" class="button-global smallb" name="button_click" value="ADD SELECTED MEALS" />
                </div>
            </form>
        </div>
    </div>
</div>

