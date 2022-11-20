<div id="wrapper" class="page-wrap print opened-max">
    {include file='portalapp/administration-sidemenu.tpl'}
    <div id="page-content-wrapper" class="container-fluid">
        <div class="content-area">
            <div class="navbar navbar-admin">
                <div class="left-align-b buttons-wrap">
                    <input onclick="location.href='{$URL}meals';"
                        type="button"
                        class="button-global smallb hollow"
                        name="button_click"
                        value="← RETURN TO MEALS LIBRARY">
                </div>
            </div>
            {include file='portalapp/meals-submenu.tpl'}
            <div class="section-wrap">
                <div class="left-align-b buttons-wrap">
                    <button onclick="location.href='{$URL}meals/editMeal?id={$mealItemIdEncoded}'" type="button" class="button-global smallb">EDIT DETAILS</button>
                </div>

                <div class="table-c-wrap">
                    <table class="table-c">
                        {if $mealData.thumbnail}
                            <tr>
                                <td><img class="equipment-image" src="{$UPLOAD_FOLDER_MEDIA}meals/{$mealData.thumbnail}" /></td>
                            </tr>
                        {/if}
                        <tr>
                            <td>Name:</td>
                            <td>{$mealData.mealName}</td>
                        </tr>
                        <tr>
                            <td>Category:</td>
                            <td>{$mealData.categoryName}</td>
                        </tr>
                        <tr>
                            <td>Price:</td>
                            <td>${$mealData.price}</td>
                        </tr>
                        <tr>
                            <td>Ingredients:</td>
                            <td>{$mealData.ingredients}</td>
                        </tr>
                        <tr>
                            <td>Nutrition Info:</td>
                            <td>{$mealData.nutritionRegular}</td>
                        </tr>
                        <tr>
                            <td>Updated:</td>
                            <td>{$mealData.lastUpdate}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
