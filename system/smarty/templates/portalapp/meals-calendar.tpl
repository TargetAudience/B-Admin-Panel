<div id="wrapper" class="page-wrap print opened-max">
    {include file='portalapp/administration-sidemenu.tpl' currentPage={$currentPage}}

    <div id="page-content-wrapper" class="container-fluid">
        <div class="content-area">
            <form action="{$URL}meals/addMealsToWeek" id="checkboxForm" method="post">
                <input type="hidden" name="weekUrlParam" value={$weekUrlParam} />

	            {include file='portalapp/meals-menu.tpl' currentPage={$subPage}}

	            <div class="sub-menu">
                	<span class="date-heading">{$startDisplay} to {$endDisplay}</span>
		            <div class="week-buttons">
						<a href="{$URL}meals/calendar?prev={$buttons['prev']}" class="weeks">&larr; Previous</a><a href="{$URL}meals/calendar?next={$buttons['next']}" class="weeks">Next &rarr;</a>
					</div>
                </div>

                <div class="navbar navbar-admin">
                    <div class="left-align-b buttons-wrap">
                        <input type="submit" class="button-global smallb" name="button_click" value="ADD MEALS TO WEEK" />
                    </div>
                </div>
                
                <div class="table-b-wrap">
                    <table class="table-b pretty">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach from=$calendarData item=item}
                                <tr>
                                    <td>
                                        {if $item.thumbnail}
                                            <img class="meals-image-listing" src="{$UPLOAD_FOLDER_MEDIA}meals/{$item.thumbnail}" />
                                        {/if}
                                    </td>
                                    <td>{$item.mealName}</td>
                                    <td>{$item.categoryName}</td>
                                    <td>${$item.price}</td>
                                    <td><a href="#" data-src="{$URL}administration/remove?type=meals&id={$item.mealsCalendarItemIdEncoded}&week={$weekUrlParam}" class="js__admin-remove-item icon-spacer"><span class="icon-trash"></span></a></td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>


            </form>
        </div>
    </div>
</div>

{include file='portalapp/administration-popups.tpl'}

