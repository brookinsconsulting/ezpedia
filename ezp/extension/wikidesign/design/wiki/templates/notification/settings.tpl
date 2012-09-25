{* DO NOT EDIT THIS FILE! Use an override template instead. *}

<form method="post" action={"/notification/settings/"|ezurl}>

<div class="maincontentheader">
<h1>{"Notification settings"|i18n('design/wiki/notification')}</h1>
</div>

{let handlers=fetch('notification','handler_list')}

    <p>
    {section name=Handlers loop=$handlers}
        {*Handler: {$Handlers:item.name}*}
	{if  not( $Handlers:item.id_string|eq("ezcollaboration") ) }
		{include handler=$Handlers:item uri=concat( "design:notification/handler/",$Handlers:item.id_string,"/settings/edit.tpl")}
	{/if}
    {/section}
    </p>
{/let}

<div>
<input class="button" type="submit" name="Store" value="{'Store'|i18n('design/wiki/notification')}" />
<input class="button" type="submit" name="Cancel" value="{'Cancel'|i18n('design/wiki/notification')}" />
</div>
</form>
