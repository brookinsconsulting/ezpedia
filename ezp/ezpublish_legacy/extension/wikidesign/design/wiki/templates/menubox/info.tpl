{* $object|attribute(show,1) *}
<div class="menubox">
    <div class="menubox-title">{'Object information'|i18n('design/wiki/content/edit')}</div>
    <div class="menubox-content">
        {* Object ID *}
        <p>
        <label>{'ID'|i18n( 'design/wiki/content/edit' )}:</label>
        {$object.object.id}
        </p>

        {* Created *}
        <p>
        <label>{'Created'|i18n( 'design/wiki/content/edit' )}:</label>
        {section show=$object.object.published}
        {$object.object.published|l10n( shortdatetime )}<br />
        <a href={$object.object.owner.main_node.url_alias|ezurl}>{$object.object.owner.name|wash}</a>
        {section-else}
        {'Not yet published'|i18n( 'design/wiki/content/edit' )}
        {/section}
        </p>

        {* Modified *}
        <p>
        <label>{'Modified'|i18n( 'design/wiki/content/edit' )}:</label>
        {section show=$object.object.modified}
        {$object.object.modified|l10n( shortdatetime )}<br />
        <a href={$object.object.current.creator.main_node.url_alias|ezurl}>{$object.object.current.creator.name|wash}</a>
        {section-else}
        {'Not yet published'|i18n( 'design/wiki/content/edit' )}
        {/section}
        </p>

        {* Published version *}
        <p>
        <label>{'Published version'|i18n( 'design/wiki/content/edit' )}:</label>
        {section show=$object.object.published}
        {$object.object.current.version}
        {section-else}
        {'Not yet published'|i18n( 'design/wiki/content/edit' )}
        {/section}
        </p>

        {* View count *}
        <p>
        <label>{'View count'|i18n( 'design/wiki/' )};</label>
        {$object.view_count}
        </p>

        {* Manage versions *}
        {*
        <div class="block">
        {section show=$object.object.versions|count|gt( 1 )}
        <input class="button" type="submit" name="VersionsButton" value="{'Manage versions'|i18n( 'design/wiki/content/edit' )}" title="{'View and manage (copy, delete, etc.) the versions of this object.'|i18n( 'design/wiki/content/edit' )}" />
        {section-else}
        <input class="button-disabled" type="submit" name="VersionsButton" value="{'Manage versions'|i18n( 'design/wiki/content/edit' )}" disabled="disabled" title="{'You can not manage the versions of this object because there is only one version available (the one that is being edited).'|i18n( 'design/wiki/content/edit' )}" />
        {/section}
        </div>
        *}
    </div>
</div>
