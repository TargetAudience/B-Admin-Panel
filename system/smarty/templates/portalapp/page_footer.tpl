<script>
window.domainBase = '{$URL}';
window.subPage = '{if isset($subPage)}{$subPage}{/if}';
window.currentPage = '{if isset($currentPage)}{$currentPage}{/if}';

var showAlert = function(type, title, message) {
    if (type ==  'danger') type = 'error';
    $.toast({
        heading: title,
        text: message,
        icon: type,
        bgColor: '#3889f3',
        textColor: 'white',
        position: 'top-center',
        allowToastClose: true,
        hideAfter: 3000,
        loader: false,
    });
};

var hideAlert = function() {
    $.toast().reset('all');
}

{if isset($successMessage) && $successMessage neq ''}
    hideAlert();
    showAlert('success-inside', '', '{$successMessage}');
    {assign var='timer' value='2000'}
    {if isset($overrideDelayTime)}
        {assign var='timer' value=$overrideDelayTime}
    {/if}
    {if !isset($freezeAlert)}
        setTimeout(function() {
            $.toast().reset('all');
        }, {$timer});
    {/if}
{/if}
</script>
</body>
</html>