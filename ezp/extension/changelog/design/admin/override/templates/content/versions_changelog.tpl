<div id="leftmenu">
<div id="leftmenu-design">

<div class="objectinfo">

<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h4>{'Object information'|i18n( 'design/admin/content/versions' )}</h4>

</div></div></div></div></div></div>

<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">

{* Object ID *}
<p>
<label>{'ID'|i18n( 'design/admin/content/versions' )}:</label>
{$object.id}
</p>

{* Created *}
<p>
<label>{'Created'|i18n( 'design/admin/content/versions' )}:</label>
{section show=$object.published}
{$object.published|l10n( shortdatetime )}<br />
{$object.current.creator.name|wash}
{section-else}
{'Not yet published'|i18n( 'design/admin/content/versions' )}
{/section}
</p>

{* Modified *}
<p>
<label>{'Modified'|i18n( 'design/admin/content/versions' )}:</label>
{section show=$object.modified}
{$object.modified|l10n( shortdatetime )}<br />
{fetch( content, object, hash( object_id, $object.content_class.modifier_id ) ).name|wash}
{section-else}
{'Not yet published'|i18n( 'design/admin/content/versions' )}
{/section}
</p>

{* Published version*}
<p>
<label>{'Published version'|i18n( 'design/admin/content/versions' )}:</label>
{section show=$object.published}
{$object.current_version}
{section-else}
{'Not yet published'|i18n( 'design/admin/content/versions' )}
{/section}
</p>

</div></div></div></div></div></div>

</div>

</div>
</div>

<div id="maincontent"><div id="fix">
<div id="maincontent-design">
<!-- Maincontent START -->

{switch match=$edit_warning}
{case match=1}
<div class="message-warning">
<h2><span class="time">[{currentdate()|l10n( shortdatetime )}]</span> {'Version not a draft'|i18n( 'design/admin/content/versions' )}</h2>
<ul>
    <li>{'Version %1 is not available for editing anymore, only drafts can be edited.'|i18n( 'design/admin/content/versions',, array( $edit_version ) )}</li>
    <li>{'To edit this version create a copy of it.'|i18n( 'design/admin/content/versions' )}</li>
</ul>
</div>
{/case}
{case match=2}
<div class="message-warning">
<h2><span class="time">[{currentdate()|l10n( shortdatetime )}]</span> {'Version not yours'|i18n( 'design/admin/content/versions' )}</h2>
<ul>
    <li>{'Version %1 was not created by you, only your own drafts can be edited.'|i18n( 'design/admin/content/versions',, array( $edit_version ) )}</li>
    <li>{'To edit this version create a copy of it.'|i18n( 'design/admin/content/versions' )}</li>
</ul>
</div>
{/case}
{case match=3}
<div class="message-warning">
<h2><span class="time">[{currentdate()|l10n( shortdatetime )}]</span> {'Unable to create new version'|i18n( 'design/admin/content/versions' )}</h2>
<ul>
    <li>{'Version history limit has been exceeded and no archived version can be removed by the system.'|i18n( 'design/admin/content/versions' )}</li>
    <li>{'You can change your version history settings in content.ini, remove draft versions or edit existing drafts.'|i18n( 'design/admin/content/versions' )}</li>
</ul>
</div>
{/case}
{case}
{/case}
{/switch}


{let page_limit=30
     version_list=fetch(content,version_list,hash(contentobject, $object,limit,$page_limit,offset,$view_parameters.offset))
     list_count=fetch(content,version_count, hash(contentobject, $object))}

<form name="versionsform" action={concat( '/content/versions/', $object.id, '/' )|ezurl} method="post">

<div class="context-block">

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h1 class="context-title">{'Versions for <%object_name> [%version_count]'|i18n( 'design/admin/content/versions',, hash( '%object_name', $object.name, '%version_count', $version_list|count ) )|wash}</h1>

{* DESIGN: Mainline *}<div class="header-mainline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">

{section show=$version_list}
<table class="list" cellspacing="0">
<tr>
    <th class="tight"><img src={'toggle-button-16x16.gif'|ezimage} alt="Toggle selection" onclick="ezjs_toggleCheckboxes( document.versionsform, 'DeleteIDArray[]' ); return false;" /></th>
    <th>{'Version'|i18n( 'design/admin/content/versions' )}</th>
    <th>{'Status'|i18n( 'design/admin/content/versions' )}</th>
    <th>{'Translations'|i18n( 'design/admin/content/versions' )}</th>
    <th>{'Creator'|i18n( 'design/admin/content/versions' )}</th>
    <th>{'Created'|i18n( 'design/admin/content/versions' )}</th>
    <th>{'Modified'|i18n( 'design/admin/content/versions' )}</th>
    <th>{'Changes'|i18n( 'design/admin/content/versions' )}</th>
    <th class="tight">&nbsp;</th>
    <th class="tight">&nbsp;</th>
</tr>

{section var=Versions loop=$version_list sequence=array( bglight, bgdark )}
<tr class="{$Versions.sequence}">

    {* Remove. *}
    <td>
        {section show=or( eq( $Versions.item.status, 0 ),eq( $Versions.item.status, 3), eq( $Versions.item.status, 4 ) )}
            <input type="checkbox" name="DeleteIDArray[]" value="{$Versions.item.id}" title="{'Select version #%version_number for removal.'|i18n( 'design/admin/content/versions',, hash( '%version_number', $Versions.item.version ) )}" />
        {section-else}
            <input type="checkbox" name="" value="" disabled="disabled" title="{'Version #%version_number can not be removed because it is either the published version of the object or because you do not have permissions to remove it.'|i18n( 'design/admin/content/versions',, hash( '%version_number', $Versions.item.version ) )}" />
        {/section}
    </td>

    {* Version/view. *}
    <td><a href={concat( '/content/versionview/', $object.id, '/', $Versions.item.version )|ezurl} title="{'View the contents of version #%version_number. Default translation: %default_translation.'|i18n( 'design/admin/content/versions',, hash( '%version_number', $Versions.item.version, '%default_translation', $object.default_language|locale().intl_language_name ) )}">{$Versions.item.version}</a></td>

    {* Status. *}
    <td>{$Versions.item.status|choose( 'Draft'|i18n( 'design/admin/content/versions' ), 'Published'|i18n( 'design/admin/content/versions' ), 'Pending'|i18n( 'design/admin/content/versions' ), 'Archived'|i18n( 'design/admin/content/versions' ), 'Rejected'|i18n( 'design/admin/content/versions' ) )}</td>

    {* Translations. *}
    <td>
        {section var=Languages loop=$Versions.item.language_list}
        {delimiter}<br />{/delimiter}
        <img src="{$Languages.item.language_code|flag_icon}" alt="{$Languages.item.language_code}" />&nbsp;<a href={concat('/content/versionview/', $object.id, '/', $Versions.item.version, '/', $Languages.item.language_code, '/' )|ezurl} title="{'View the contents of version #%version_number. Translation: %translation.'|i18n( 'design/admin/content/versions',, hash( '%translation', $Languages.item.locale.intl_language_name, '%version_number', $Versions.item.version ) )}" >{$Languages.item.locale.intl_language_name}</a>
        {/section}
    </td>

    {* Creator. *}
    <td>{$Versions.item.creator.name|wash}</td>

    {* Created. *}
    <td>{$Versions.item.created|l10n( shortdatetime )}</td>

    {* Modified. *}
    <td>{$Versions.item.modified|l10n( shortdatetime )}</td>

    {* Changes *}
    <td>{$Versions.item.data_map.changelog.content|wash( xhtml )|nl2br}</td>

    {* Copy button. *}
    <td>
        {section show=$can_edit}
        <input class="button" type="submit" name="CopyVersionButton[{$Versions.item.version}]" value="{'Copy'|i18n( 'design/admin/content/versions' )}" title="{'Create a copy of version #%version_number.'|i18n( 'design/admin/content/versions',, hash( '%version_number', $Versions.item.version ) )}" />
        {section-else}
        <input class="button-disabled" type="submit" name="" value="{'Copy'|i18n( 'design/admin/content/versions' )}" disabled="disabled" title="{'You can not make copies of versions because you do not have permissions to edit the object.'|i18n( 'design/admin/content/versions' )}" />
        {/section}
    </td>

    {* Edit button. *}
    <td>
        {section show=and( $Versions.item.status|eq( 0 ), $Versions.item.creator_id|eq( $user_id ), $can_edit ) }
        <input class="button" type="submit" name="EditButton[{$Versions.item.version}]" value="{'Edit'|i18n( 'design/admin/content/versions' )}" title="{'Edit the contents of version #%version_number.'|i18n( 'design/admin/content/versions',, hash( '%version_number', $Versions.item.version ) )}" />
        {section-else}
        <input class="button-disabled" type="submit" name="" value="{'Edit'|i18n( 'design/admin/content/versions' )}" disabled="disabled" title="{'You can not edit the contents of version #%version_number either because it is not a draft or because you do not have permissions to edit the object.'|i18n( 'design/admin/content/versions',, hash( '%version_number', $Versions.item.version ) )}" />
        {/section}
    </td>

</tr>
{/section}
</table>
{section-else}
<div class="block">
<p>{'This object does not have any versions.'|i18n( 'design/admin/content/versions' )}</p>
</div>
{/section}

<div class="context-toolbar">
{include name=navigator
         uri='design:navigator/google.tpl'
         page_uri=concat( '/content/versions/', $object.id, '///' )
         item_count=$list_count
         view_parameters=$view_parameters
         item_limit=$page_limit}
</div>

{* DESIGN: Content END *}</div></div></div>

<div class="controlbar">
{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">

<div class="block">

<div class="left">
<input class="button" type="submit" name="RemoveButton" value="{'Remove selected'|i18n( 'design/admin/content/versions' )}" title="{'Remove the selected versions from the object.'|i18n( 'design/admin/content/versions' )}" />
<input type="hidden" name="EditLanguage" value="{$edit_language}" />
<input type="hidden" name="DoNotEditAfterCopy" value="" />
</div>

<div class="right">
{section show=is_set( $redirect_uri )}
<input class="text" type="hidden" name="RedirectURI" value="{$redirect_uri}" />
{/section}
<input class="button" type="submit" name="BackButton" value="Back" />
</div>
<div class="break"></div>
</div>

{* DESIGN: Control bar END *}</div></div></div></div></div></div>

</div>

</div>
</form>

{/let}


<!-- Maincontent END -->
</div>
<div class="break"></div>
</div></div>
