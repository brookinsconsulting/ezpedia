{*$object|attribute(show,1) *}

<div class="menubox">
    <div class="menubox-title"><a href={concat( "/about/namespaces", "" )|ezurl} style="text-decoration:none;color:#000000;">{'Namespaces'|i18n('design/wiki/content/edit')}</a></div>
    <div class="menubox-content">
        {* Namespaces *}
{*                                                'class_filter_type', 'include',
                                                'class_filter_array', array( 'folder0','namespace' ),
*}
        {* <p>
        <label>{'> New <'|i18n( 'design/wiki/content/edit' )}:</label>*}

	{let $namespaces=fetch( 'content', 'list', hash( 'parent_node_id', 2, 'class_id', 16,
	'sort_by', array( 'priority', true() ) ) )}
	{* $namespaces|attribute(show,1) *}
	<ul>
	{def $exclusions="'template','spotlight','historical','test_notifications'"}
	{foreach $namespaces as $n}
	
	{* $n|attribute(show,1) *}
	{* section show=$n.url|ne( $exclusions ) *}
	{* section show=$n.url|ne( array( 'snippets_for_ez_publish_3', 'spotlight', 'template', 'historical', 'test_notifications' ) ) *}

	{if array( 'spotlight', 'template', 'snippets_for_ez_publish_3', 'historical', 'test_notifications' )|contains( $n.url )|not}
	{section show=$n.object.published}
	<li><a href={$n.url|ezurl} style="font-size: 1.4em;">{$n.name}</a></li>
	{/section}
	{/if}
	
	{/foreach}
	</ul>
	{/let}
        {* </p> *}
    </div>
</div>
