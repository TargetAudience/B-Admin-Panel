{if $page_nums['total_pages'] gt 1}
    <div class="pagination">
        <ul>
            <!-- Prev -->
            {if (($page_nums['page_number'])>=($page_nums['page_number']+1))}
                <li class="number arrow off"><a href="javascript:;"><i class="chevron-left"></i></a></li>
            {else}
                {if ($page_nums['page_number']-1)==0}
                    <li class="number arrow off"><a href="javascript:;"><i class="fa fa-chevron-left"></i></a></li>
                {else}
                    <li class="number arrow"><a href="{$URL}users?page={($page_nums['page_number']-1)}&type={$subPage}"><i class="fa fa-chevron-left"></i></a></li>
                {/if}
            {/if}

            {section name="page" loop={$page_nums['total_pages']} start=0}
                {if $page_nums['page_number'] eq {$smarty.section.page.index+1}}
                    <li class="number"><a href="javascript:;" id="selected">{$smarty.section.page.index+1}</a></li>
                {else}
                    <li class="number"><a href="{$URL}users?page={$smarty.section.page.index+1}&type={$subPage}">{$smarty.section.page.index+1}</a></li>
                {/if}
            {/section}

            <!-- Next -->
            {if ($page_nums['page_number'])<=($page_nums['total_pages']-1)}
                <li class="number arrow"><a href="{$URL}users?page={($page_nums['page_number']+1)}&type={$subPage}"><i class="fa fa-chevron-right"></i></a></li>
            {else}
                <li class="number arrow off"><a href="javascript:;"><i class="fa fa-chevron-right"></i></a></li>
            {/if}
        </ul>
    </div>
{/if}
