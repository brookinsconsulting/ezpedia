{default $currentUser=fetch('user','current_user')}
{if $currentUser.is_logged_in}
<div class="menubox">
    <div class="menubox-title">{'Current visitors'|i18n('design/wiki/pagelayout')}</div>
    <div class="menubox-content">
    {let logged_in_count=fetch( user, logged_in_count )}
    {'There are %logged_in_count registered users online.'|i18n( 'design/wiki/pagelayout',,
      hash( '%logged_in_count', $logged_in_count ) )}
    {/let}
    </div>
</div>
{/if}
{/default}