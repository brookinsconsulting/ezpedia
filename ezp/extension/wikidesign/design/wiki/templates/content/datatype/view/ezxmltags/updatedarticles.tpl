{let $list_items=fetch( content, tree, hash( parent_node_id, 2,
                                             offset, first_set( $view_parameters.offset, 0 ),
                                             sort_by, array( array( 'modified', false() ) ),
    'class_filter_type', 'exclude',
    'class_filter_array', array( 'forum_topic', 'forum_reply' ),

                                             limit, 20 ) )
     $list_count=fetch( content, tree_count, hash( parent_node_id, 2,
                                                   offset, first_set( $view_parameters.offset, 0),
    'class_filter_type', 'exclude',
    'class_filter_array', array( 'forum_topic', 'forum_reply' ),

						   limit, 20
                                                  ) )
}
{*
     $langArray=cond(is_set( $langcode ), array( $langcode ), true(), false() )
     $articleCount=fetch( 'content', 'tree_count', hash(
    'parent_node_id', 2,
    'class_filter_type', 'include',
    'class_filter_array', array( 'wiki_article' ),
    'language', $langArray
    ))
{$articleCount} {$content|wash}
*}

  <div class="content-view-children" style="padding-left: 1.37%;">
   <span class="rss-link"><a href="/rss/updated/updated"><img src={'images/icons/feed/feed-icon-16x16.png'|ezdesign} alt="ezpedia.org updated content rss feed" /></a></span>

    <ol>
    {section var=child loop=$list_items show=$list_items sequence=array(bglight,bgdark)}
     {* <div>{node_view_gui view=line content_node=$child}</div> *}
     {* $child.object|attribute(show,1)}{break *}
     <li style="font-size: xx-small;"><a style="font-size: xx-small;" href={$child.parent.url|ezurl}>{$child.parent.name}</a> : <a style="font-size: medium" href={$child.url|ezurl}>{$child.name|wash}</a></li>
     <ul style="list-style-type: none;"><li style="font-size: xx-small;"> @{$child.object.current_version} | <span style="font-size: xx-small">{$child.object.current.modified|datetime( 'custom', '%Y/%m/%d @ %H:%i:%s' )}</span> : <a style="font-size: xx-small;" href={$child.object.current.creator.main_node.url|ezurl}>{$child.object.current.creator.name}</a> : <a href={concat( '/content/history/', $child.object.id )|ezurl}>History</a>  {if $child.object.data_map.changelog.data_text|is_set}{$child.object.data_map.changelog.data_text}{/if}</li></ul>
     {section-else}
       <p>{"There is no new content since your last visit."|i18n("design/standard/content/newcontent")}</p>
     {/section}
    </ol>
   </div>
{/let}