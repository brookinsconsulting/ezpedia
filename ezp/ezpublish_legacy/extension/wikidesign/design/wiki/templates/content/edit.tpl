<form name="editform" id="editform" enctype="multipart/form-data" method="post" action={concat( '/content/edit/', $object.id, '/', $edit_version, '/', $edit_language|not|choose( concat( $edit_language, '/' ), '/' ), $is_translating_content|not|choose( concat( $from_language, '/' ), '' ) )|ezurl}>
<div id="columns">
    <div id="leftmenu">
        <div id="wiki_title">
            {include uri="design:page_logo.tpl"}
        </div>

        {include uri="design:menubox/edit.tpl"}
    </div>

    <div id="maincontent">
        <div id="maincontent-design">


    <div style="display:none;">
    <input type="hidden" name="UseNodeAssigments" value="0" />
    </div>

    <div class="maincontentheader">
    <h1>{"Edit %1 - %2"|i18n("design/wiki/content/edit",,array($class.name|wash,$object.name|wash))}</h1>
    </div>

     <div class="context-information">
{let language_index=0
     from_language_index=0
     translation_list=$content_version.translation_list}

{section loop=$translation_list}
  {section show=eq( $edit_language, $item.language_code )}
    {set language_index=$:index}
  {/section}
{/section}

{section show=$is_translating_content}

    {let from_language_object=$object.languages[$from_language]}

    {'Translating content from %from_lang to %to_lang'|i18n( 'design/wiki/content/edit',, hash(
        '%from_lang', concat( $from_language_object.name, '&nbsp;<img src="', $from_language_object.locale|flag_icon, '" style="vertical-align: middle;" alt="', $from_language_object.locale, '" />' ),
        '%to_lang', concat( $translation_list[$language_index].locale.intl_language_name, '&nbsp;<img src="', $translation_list[$language_index].language_code|flag_icon, '" style="vertical-align: middle;" alt="', $translation_list[$language_index].language_code, '" />' ) ) )}

    {/let}

{section-else}

    {$translation_list[$language_index].locale.intl_language_name}&nbsp;<img src="{$translation_list[$language_index].language_code|flag_icon}" style="vertical-align: middle;" alt="{$translation_list[$language_index].language_code}" />

{/section}

{/let}

    <div align="right">
    <input class="defaultbutton" type="submit" name="PublishButton" value="{'Send for publishing'|i18n('design/wiki/content/edit')}" />
    <input class="button" type="submit" name="StoreButton" value="{'Store draft'|i18n('design/wiki/content/edit')}" />
    <input class="button" type="submit" name="DiscardButton" value="{'Discard'|i18n('design/wiki/content/edit')}" />
    </div>

</div>

    {include uri="design:content/edit_validation.tpl"}

{section show=$is_translating_content}
<div class="content-translation">
{/section}
<div class="context-attributes">
    {include uri="design:content/edit_attribute.tpl"}
</div>
{section show=$is_translating_content}
</div>
{/section}

<div class="block">
<label>{'Related articles'|i18n( 'design/wiki/content/edit')}</label><div class="labelbreak"></label>

<table class="list" id="related-objects">
    <tr>
        <th>{'Name'|i18n( 'design/wiki/content/edit')}</th>
        <th>{'XML code'|i18n( 'design/wiki/content/edit')}</th>
        <th>&nbsp;</th>
    </tr>
    {section name=Object loop=$related_contentobjects sequence=array(bglight,bgdark)}
    <tr class="{$Object:sequence}">
        <td align="left">
            {node_view_gui view=thumb content_node=$Object:item.main_node}
        </td>
        <td>&lt;embed href='ezobject://{$Object:item.id}' /&gt;</td>
        <td align="right" width="1">
          <input type="checkbox" name="DeleteRelationIDArray[]" value="{$Object:item.id}" />
        </td>
    </tr>
    {/section}
    <tr>
        <td align="right" colspan="2">
          <div class="buttonblock">
{*          <input class="menubutton" type="submit" name="BrowseObjectButton" value="{'Find'|i18n('design/wiki/content/edit')}" />*}
            <input class="menubutton" type="image" name="BrowseObjectButton" value="{'Find'|i18n('design/wiki/content/edit')}" src={"find.png"|ezimage} />
    {section show=$related_contentobjects}
{*          <input class="menubutton" type="submit" name="DeleteRelationButton" value="{'Remove'|i18n('design/wiki/content/edit')}" />*}
            <input class="menubutton" type="image" name="DeleteRelationButton" value="{'Remove'|i18n('design/wiki/content/edit')}" src={"trash.png"|ezimage} />
    {/section}
          </div>
        </td>
    </tr>
</table>
</div>

    <div class="buttonblock">
{def $lastAccessesURI=ezhttp( 'LastAccessesURI', 'session' )
     $hasRedirectAccess=fetch( 'user', 'has_access_to', hash( 'module', 'redirect',
                                                              'function', 'redirect') )
     $isPublished=$object.is_published
     $redirectURIAfterPublish=false()}

{if $isPublished}
    {set $redirectURIAfterPublish=$object.main_node.url_alias}
{else}
    {if $hasRedirectAccess}
        {set $redirectURIAfterPublish=concat('/redirect/mainnode/',$object.id)}
    {elseif $lastAccessesURI}
        {set $redirectURIAfterPublish=$lastAccessesURI}
{/if}

{if $redirectURIAfterPublish|is_string}
    <input type="hidden" name="RedirectURIAfterPublish" value="{$lastAccessesURI}"/>
{else}
    <input type="hidden" name="RedirectURIAfterPublish" value="/"/>
{/if}

{if $lastAccessesURI}
    <input type="hidden" name="RedirectIfDiscarded" value="{$lastAccessesURI}"/>
{/if}

{undef $lastAccessesURI
       $hasRedirectAccess
       $isPublished
       $redirectURIAfterPublish}

    <input type="hidden" name="DiscardConfirm" value="0" />

    <input class="defaultbutton" type="submit" name="PublishButton" value="{'Send for publishing'|i18n('design/wiki/content/edit')}" />
    <input class="button" type="submit" name="StoreButton" value="{'Store draft'|i18n('design/wiki/content/edit')}" />
    <input class="button" type="submit" name="DiscardButton" value="{'Discard'|i18n('design/wiki/content/edit')}" />
    </div>

    </div>
</div>

<div class="break"></div>

</div>{* id="columns" *}
</form>
