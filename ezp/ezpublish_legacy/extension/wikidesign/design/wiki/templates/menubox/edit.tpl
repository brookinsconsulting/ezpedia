<div class="menubox">
    <div class="menubox-title">{'Object information'|i18n('design/wiki/content/edit')}</div>
    <div class="menubox-content">
        {* Object ID *}
        <p>
        <label>{'ID'|i18n( 'design/wiki/content/edit' )}:</label>
        {$object.id}
        </p>
        
        {* Created *}
        <p>
        <label>{'Created'|i18n( 'design/wiki/content/edit' )}:</label>
        {section show=$object.published}
        {$object.published|l10n( shortdatetime )}<br />
        {$object.owner.name|wash}
        {section-else}
        {'Not yet published'|i18n( 'design/wiki/content/edit' )}
        {/section}
        </p>
        
        {* Modified *}
        <p>
        <label>{'Modified'|i18n( 'design/wiki/content/edit' )}:</label>
        {section show=$object.modified}
        {$object.modified|l10n( shortdatetime )}<br />
        {$object.current.creator.name|wash}
        {section-else}
        {'Not yet published'|i18n( 'design/wiki/content/edit' )}
        {/section}
        </p>
        
        {* Published version *}
        <p>
        <label>{'Published version'|i18n( 'design/wiki/content/edit' )}:</label>
        {section show=$object.published}
        {$object.current.version}
        {section-else}
        {'Not yet published'|i18n( 'design/wiki/content/edit' )}
        {/section}
        </p>
        
        {* Manage versions *}
        {*
        <div class="block">
        {section show=$object.versions|count|gt( 1 )}
        <input class="button" type="submit" name="VersionsButton" value="{'Manage versions'|i18n( 'design/wiki/content/edit' )}" title="{'View and manage (copy, delete, etc.) the versions of this object.'|i18n( 'design/wiki/content/edit' )}" />
        {section-else}
        <input class="button-disabled" type="submit" name="VersionsButton" value="{'Manage versions'|i18n( 'design/wiki/content/edit' )}" disabled="disabled" title="{'You can not manage the versions of this object because there is only one version available (the one that is being edited).'|i18n( 'design/wiki/content/edit' )}" />
        {/section}
        </div>
        *}
    </div>
</div>



<div class="menubox">
    <div class="menubox-title">{'Current draft'|i18n('design/wiki/content/edit')}</div>
    <div class="menubox-content">

        {* Created *}
        <p>
        <label>{'Created'|i18n( 'design/wiki/content/edit' )}:</label>
        {$content_version.created|l10n( shortdatetime )}<br />
        {$content_version.creator.name|wash}
        </p>
        
        {* Modified *}
        <p>
        <label>{'Modified'|i18n( 'design/wiki/content/edit' )}:</label>
        {$content_version.modified|l10n( shortdatetime )}<br />
        {$content_version.creator.name|wash}
        </p>
        
        {* Version *}
        <p>
        <label>{'Version'|i18n( 'design/wiki/content/edit' )}:</label>
        {$edit_version}
        </p>
        
        <div class="block">
        <input class="button" type="submit" name="PreviewButton" value="{'Preview'|i18n( 'design/wiki/content/edit' )}" title="{'View the draft that is being edited.'|i18n( 'design/wiki/content/edit' )}" />
        </div>
        <div class="block">
        <input class="button" type="submit" name="StoreExitButton" value="{'Store and exit'|i18n( 'design/wiki/content/edit' )}" title="{'Store the draft that is being edited and exit from edit mode.'|i18n( 'design/wiki/content/edit' )}" />
        </div>

    </div>
</div>


<div class="menubox">
    <div class="menubox-title">{'Translate from'|i18n('design/wiki/content/edit')}</div>
    <div class="menubox-content">

    <label style="display:block;">
    <input type="radio" name="FromLanguage" value=""{if $from_language|not} checked="checked"{/if}{if $object.status|eq(0)} disabled="disabled"{/if} /> {'No translation'|i18n( 'design/wiki/content/edit' )}
    </label>

    {if $object.status}
    {foreach $object.languages as $language}
    <label style="display:block;">
    <input type="radio" name="FromLanguage" value="{$language.locale}"{if $language.locale|eq($from_language)} checked="checked"{/if} />
    <img src="{$language.locale|flag_icon}" alt="{$language.locale}" style="vertical-align: middle;" /> 
    {$language.name|wash}
    </label>
    {/foreach}
    {/if}

    <div class="block">
    <input {if $object.status|eq(0)}class="button-disabled" disabled="disabled"{else} class="button"{/if} type="submit" name="FromLanguageButton" value="{'Translate'|i18n( 'design/wiki/content/edit' )}" title="{'Edit the current object showing the selected language as a reference.'|i18n( 'design/wiki/content/edit' )}" />
    </div>

    </div>
</div>

