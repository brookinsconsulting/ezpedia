<div class="content-new">
<span class="rss-link"><a href="/rss/updated/updated"><img src={'images/icons/feed/feed-icon-28x28.png'|ezdesign} alt="ezpedia.org updated content rss feed"/></a></span>

    <h1>{$node.name|wash}{* "Updated articles"|i18n("design/standard/content/newcontent") *}</h1>
{*    <p>{"Your last visit to this site was"|i18n("design/standard/content/newcontent")}: {$last_visit_timestamp|l10n(datetime)}</p> *}
<style>
{literal}
div.break {
clear: none;
}
{/literal}
</style>
    {let page_limit=75
         list_items=array()
         list_count=0
         time_filter=array( array( 'modified', '>=', $last_visit_timestamp ) )}
{*
        {set list_items=fetch( content, tree, hash( parent_node_id, 2,
                                                    offset, first_set( $view_parameters.offset, 0),
                                                    attribute_filter, $time_filter,
                                                    sort_by, array( array( 'modified', false() ) ),
                                                    limit, $page_limit ) )
             list_count=fetch( content, tree_count, hash( parent_node_id, 2,
                                                          offset, first_set( $view_parameters.offset, 0),
                                                          attribute_filter, $time_filter ) )}
*}

        {set list_items=fetch( content, tree, hash( parent_node_id, 2,
                                                    offset, first_set( $view_parameters.offset, 0),
                                                    sort_by, array( array( 'modified', false() ) ),
                                                    limit, $page_limit ) )
             list_count=fetch( content, tree_count, hash( parent_node_id, 2,
                                                          offset, first_set( $view_parameters.offset, 0),
                                                        ) )}
            {include name=navigator
                     uri='design:navigator/google.tpl'
                     page_uri='/updated'
                     item_count=$list_count
                     view_parameters=$view_parameters
                     item_limit=$page_limit}

            {* <div class="content-view-children" style="position:relative; top:-20%"> *}
	    <div class="content-view-children" style="padding-left: 1.37%;">
	    <ol>
                {section var=child loop=$list_items show=$list_items sequence=array(bglight,bgdark)}
                    {* <div>{node_view_gui view=line content_node=$child}</div> *}
		    {* $child.object|attribute(show,1)}{break *}
		    <li style="font-size: xx-small;"><a style="font-size: xx-small;" href={$child.parent.main_node.url|ezurl}>{$child.parent.name}</a> : <a style="font-size: large" href={$child.url|ezurl}>{$child.name|wash}</a></li>
		    <ul style="list-style-type: none;"><li style="font-size: xx-small;"> @{$child.object.current_version} | <span style="font-size: xx-small">{$child.object.current.modified|datetime( 'custom', '%Y/%m/%d @ %H:%i:%s' )}</span> : <a style="font-size: xx-small;" href={$child.object.current.creator.main_node.url|ezurl}>{$child.object.current.creator.name}</a> : <a href={concat( '/content/history/', $child.object.id )|ezurl}>History</a>  {if $child.object.data_map.changelog.data_text|is_set}{$child.object.data_map.changelog.data_text}{/if}</li></ul>
                {section-else}
                     <p>{"There is no new content since your last visit."|i18n("design/standard/content/newcontent")}</p>
                {/section}
		</ol>
            </div>

            {include name=navigator
                     uri='design:navigator/google.tpl'
                     page_uri='/updated'
                     item_count=$list_count
                     view_parameters=$view_parameters
                     item_limit=$page_limit}
        {/let}
</div>
