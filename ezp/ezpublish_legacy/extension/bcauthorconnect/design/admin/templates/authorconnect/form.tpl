{* Node override template for author contact form *}

<form name="fullview" method="post" action={"/authorconnect/formprocess"|ezurl}>

{section show=$validation.processed}
        <div class="message-warning">
            <h2><span class="time">[{currentdate()|l10n( shortdatetime )}]</span> {'Missing or invalid input'|i18n( 'extension/bcauthorconnect' )}</h2>
            <ul>
            {section name=UnvalidatedAttributes loop=$:validation.attributes show=$:validation.attributes}
            	<li>{$:item.name|wash}: {$:item.description}</li>
          	{/section}
            </ul>
        </div>
{/section}

<div class="context-block">

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h1 class="context-title">{'Author contact form'|i18n( 'extension/bcauthorconnect' )}</h1>

{* DESIGN: Mainline *}<div class="header-mainline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">

<div class="context-attributes">

{* Contact *}
<div class="block">
    <label>{'Contact'|i18n( 'extension/bcauthorconnect' )}:</label>
    {$author_name}
</div>

{* Name *}
{let current_user=fetch( user, current_user )}
<div class="block">
    <label>{'Name'|i18n( 'extension/bcauthorconnect' )} <span class="required">({'required'|i18n( 'extension/bcauthorconnect' )})</span>:</label>
    {section show=$current_user.is_logged_in}
        <input class="box" type="text" size="25" name="Name" value="{$current_user.contentobject.name|wash(xhtml)}" />
    {section-else}
        <input class="box" type="text" size="25" name="Name" value="{$name}" />
    {/section}
</div>

{* Email address *}
<div class="block">
    <label>{'E-mail'|i18n( 'extension/bcauthorconnect' )} <span class="required">({'required'|i18n( 'extension/bcauthorconnect' )})</span>:</label>
    {section show=$current_user.is_logged_in}
        <input class="box" type="text" size="25" name="Email" value="{$current_user.email|wash(xhtml)}" />
    {section-else}
        <input class="box" type="text" size="25" name="Email" value="{$email}" />
    {/section}
</div>

{* Subject *}
<div class="block">
    <label>{'Subject'|i18n( 'extension/bcauthorconnect' )} <span class="required">({'required'|i18n( 'extension/bcauthorconnect' )})</span>:</label>
        <input class="box" type="text" size="25" name="Subject" value="{$subject}" />
</div>

{* Message *}
<div class="block">
    <label>{'Message'|i18n( 'extension/bcauthorconnect' )} <span class="required">({'required'|i18n( 'extension/bcauthorconnect' )})</span>:</label>
    <textarea class="box" name="Message" cols="60" rows="10">{$message|wash}</textarea>
</div>

{/let}

</div>

<input type="hidden" name="ContentObjectID" value="{$object_id}" />
<input type="hidden" name="ContentNodeID" value="{$node_id}" />
<input type="hidden" name="UserRedirectURI" value="{$redirect_uri}" />

{* DESIGN: Content END *}</div></div></div>

<div class="controlbar">
{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
<div class="block">
	<input class="button" type="submit" name="SendButton" value="{'Send a message'|i18n( 'extension/bcauthorconnect' )}" />
	<input class="button" type="submit" name="CancelButton" value="{'Cancel'|i18n( 'extension/bcauthorconnect' )}" />
</div>
{* DESIGN: Control bar END *}</div></div></div></div></div></div>
</div>

</div>

</form>
