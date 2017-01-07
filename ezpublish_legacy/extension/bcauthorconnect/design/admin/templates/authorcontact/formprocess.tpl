<form name="fullview" method="post" action={"/authorcontact/formprocess"|ezurl}>

<div class="context-block">

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h1 class="context-title">{'Author contact form'|i18n( 'extension/authorcontact' )}</h1>

{* DESIGN: Mainline *}<div class="header-mainline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">

<div class="context-attributes">

{section show=$mail_result}
	<p>{'Thank you. Your message was sent successfully.'|i18n( 'extension/authorcontact' )}</p>
{section-else}
	<p>{'Message was not sent.'|i18n( 'extension/authorcontact' )}</p>
{/section}

<input type="hidden" name="ContentNodeID" value="{$node_id}" />
<input type="hidden" name="UserRedirectURI" value="{$redirect_uri}" />

</div>
{* DESIGN: Content END *}</div></div></div>

<div class="controlbar">
{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
<div class="block">
	<input class="button" type="submit" name="BackButton" value="{'Back'|i18n( 'extension/authorcontact' )}" />
</div>
{* DESIGN: Control bar END *}</div></div></div></div></div></div>
</div>

</div>

</form>