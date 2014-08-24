{* Needed variables:
   - $object
*}
{def $translations=$object.languages
     $translations_count=$translations|count
     $otherLanguages=array()
     $localSiteURLList=ezini('RegionalSettings','SiteURLList','wiki.ini')}

{foreach $translations as $translation}
    {if $translation.locale|ne($object.current_language)}
        {set $otherLanguages=$otherLanguages|append($translation)}
    {/if}
{/foreach}
{* $object|attribute(show,1) *}
{* $translations|attribute(show,1) *}
{if $otherLanguages|count|gt(0)}
<div class="menubox">
    <div class="menubox-title">{'Other languages'|i18n('design/wiki/pagelayout')}</div>
     <div class="menubox-content">
     {if $object.current_language|ne(ezini('RegionalSettings','ContentObjectLocale'))}
        {def $localSiteURL=concat($object.main_node.url_alias, '/(language)/', $object.current_language )|ezurl('no')}
        {if is_set($localSiteURLList[$object.current_language])}
        {set $localSiteURL=concat( $localSiteURLList[$object.current_language],$object.main_node.url_alias)}
        {/if}
        <p>Currently using {* | {$object.current_language} | *}
        <img src="{$object.current_language|flag_icon}" alt="{$object.current_language}" />&nbsp;
        <a href="{$localSiteURL}" title="{'View translation'|i18n( 'design/wiki/pagelayout' )}">{$object.current_language_object.locale_object.language_name|wash}</a>
        </p>
        {undef $localSiteURL}
     {/if}
        <ul class="languages">
        {foreach $otherLanguages as $translation}
        {def $localSiteURL=concat($object.main_node.url_alias, '/(language)/', $translation.locale )|ezurl('no')}

        {if is_set($localSiteURLList[$translation.locale])}
          {* set $localSiteURL=concat( $localSiteURLList[$translation.locale],$object.main_node.url_alias) *}
	  {set $localSiteURL=concat( $localSiteURLList[$translation.locale],$object.main_node.url_alias)}
        {/if}

        <li>
        {* Language name. *}
        <img src="{$translation.locale|flag_icon}" alt="{$translation.locale}" />&nbsp;
        <a href="{$localSiteURL}" title="{'View translation'|i18n( 'design/wiki/pagelayout' )}">{$translation.locale_object.language_name|wash}</a>
        </li>
        {undef $localSiteURL}
        {/foreach}
        </ul>
    </div>
</div>
{/if}

{undef $translations $translations_count $otherLanguages $localSiteURLList}