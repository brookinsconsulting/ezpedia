<div class="content-new">
<span class="rss-link"><a href="/rss/updated/discussion"><img src={'images/icons/feed/feed-icon-28x28.png'|ezdesign} alt="ezpedia.org discussions rss feed"/></a></span>
 
   <h1>{$node.name|wash}{* "Updated articles"|i18n("design/standard/content/newcontent") *}</h1>
{*    <p>{"Your last visit to this site was"|i18n("design/standard/content/newcontent")}: {$last_visit_timestamp|l10n(datetime)}</p> *}
<style>
{literal}
div.break {
clear: none;
}
{/literal}
</style>
    {let page_limit=10
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
                                                    limit, $page_limit,
                                              'class_filter_type',  'include',
                                              'class_filter_array', array( 'forum','forum_reply','forum_topic' )
 ) )
             list_count=fetch( content, tree_count, hash( parent_node_id, 2,
                                                          offset, first_set( $view_parameters.offset, 0),
                                              'class_filter_type',  'include',
                                              'class_filter_array', array( 'forum','forum_reply','forum_topic' )

                                                        ) )}
            {include name=navigator
                     uri='design:navigator/google.tpl'
                     page_uri='/discussion'
                     item_count=$list_count
                     view_parameters=$view_parameters
                     item_limit=$page_limit}

            {* <div class="content-view-children" style="position:relative; top:-20%"> *}
	    <div class="content-view-children" style="padding-left: 1.37%;">
	    <ol>
                {section var=child loop=$list_items show=$list_items sequence=array(bglight,bgdark)}
                    {* <div>{node_view_gui view=line content_node=$child}</div> *}
		    {* $child.object|attribute(show,1)}{break *}
		    <li style="font-size: xx-small;">
{if $child.class_identifier|eq( 'forum_reply' )}
		    <a style="font-size: large" href={concat( $child.parent.url, '#msg', $child.node_id )|ezurl}>{$child.parent.name|wash}</a> : 
		    <a style="font-size: large" href={concat( $child.parent.url, '#msg', $child.node_id )|ezurl}>{$child.name|wash}</a>
{elseif $child.class_identifier|eq( 'forum_topic' )}
		    <a style="font-size: large" href={concat( $child.url, '#msg', $child.node_id )|ezurl}>{$child.name|wash}</a>
{elseif $child.class_identifier|eq( 'forum' )}
		    <a style="font-size: large" href={concat( $child.url, '' )|ezurl}>{$child.name|wash}</a>
{/if}
</li>

{* 		    <a style="font-size: large" href={concat( $child.parent.url, '' )|ezurl}>{$child.name|wash}</a></li> *}
{*		    <a style="font-size: large" href={concat( $child.parent.url, '#msg', $child.contentobject_id )|ezurl}>{$child.name|wash}</a></li> *}
		    <ul style="list-style-type: none;">
{if $child.class_identifier|eq( 'forum_reply' )}
		    <li style="font-size: xx-small;"> @ <a style="font-size: xx-small;" href={$child.parent.parent.parent.parent.url|ezurl}>{$child.parent.parent.parent.parent.name}</a> : <a style="font-size: xx-small;" href={$child.parent.parent.parent.url|ezurl}>{$child.parent.parent.parent.name}</a> : <a style="font-size: xx-small;" href={$child.parent.parent.url|ezurl}>{$child.parent.parent.name}</a> : <a style="font-size: xx-small;" href={$child.parent.url|ezurl}>{$child.parent.name}</a></li>
{elseif $child.class_identifier|eq( 'forum_topic' )}
		    <li style="font-size: xx-small;"> @ <a style="font-size: xx-small;" href={$child.parent.parent.parent.url|ezurl}>{$child.parent.parent.parent.name}</a> : <a style="font-size: xx-small;" href={$child.parent.parent.url|ezurl}>{$child.parent.parent.name}</a> : <a style="font-size: xx-small;" href={$child.parent.url|ezurl}>{$child.parent.name}</a></li>
{elseif $child.class_identifier|eq( 'forum' )}
		    <li style="font-size: xx-small;"> @ <a style="font-size: xx-small;" href={$child.parent.parent.parent.url|ezurl}>{$child.parent.parent.parent.name}</a> : <a style="font-size: xx-small;" href={$child.parent.parent.url|ezurl}>{$child.parent.parent.name}</a> : <a style="font-size: xx-small;" href={$child.parent.url|ezurl}>{$child.parent.name}</a></li>
{/if}
		    <li style="font-size: xx-small;"> @{$child.object.current_version} | <span style="font-size: xx-small">{$child.object.current.modified|datetime( 'custom', '%Y/%m/%d @ %H:%i:%s' )}</span> : <a style="font-size: xx-small;" href={$child.object.current.creator.main_node.url|ezurl}>{$child.object.current.creator.name}</a> {* : <a href={concat( '/content/history/', $child.object.id )|ezurl}>History</a> *}</li>

		    {* <p>Message</p> *}{* <p>{$child.object.data_map.message.data_text}</p></li> *}{* <p>{attribute_view_gui attribute=$child.object.data_map.message}</p></li> *}

		    {if $child.object.data_map.message.data_text|is_set}<li>
		    <table class=forumReplyBtn border=0><tr>
		    {* <td>{$child.object|attribute(show,1)}</td> *}

		    {if $child.object.class_identifier|eq( 'forum_reply' )}
		       {section show=$child.parent.can_create}{* $child.name}<br /> *}
		       <td>
		       <form name="reply{$child.parent.contentobject_id}" method="post" action={"content/action/"|ezurl}>
		       <input class="button forum-new-reply" type="submit" name="NewButton" value="{'New reply'|i18n( 'design/base' )}" />
                       <input type="hidden" name="ClassIdentifier" value="forum_reply" />
	               <input type="hidden" name="ContentObjectID" value="{$child.parent.contentobject_id}" />
                       <input type="hidden" name="ContentNodeID" value="{$child.parent.node_id}" />
                       <input type="hidden" name="NodeID" value="{$child.parent.node_id}" />
                       <br /><input class="button forum-keep-me-updated" type="submit" name="ActionAddToNotification" value="{'Keep me updated'|i18n( 'design/base' )}" />
		       <input name="ContentObjectLanguageCode" value="eng-GB" type="hidden" />

            	       </form>
	    	       </td>
  	 	       <td><p>{$child.object.data_map.message.content|simpletags|wordtoimage|autolink}</p></td>
		       {/section}
	{elseif $child.object.class_identifier|eq( 'forum_topic' )}
            {section show=$child.object.can_create}{* $child.name}<br /> *}
	    <td>
            <form name="reply{$child.contentobject_id}" method="post" action={"content/action/"|ezurl}>
                <input class="button forum-new-reply" type="submit" name="NewButton" value="{'New reply'|i18n( 'design/base' )}" />
                <input type="hidden" name="ClassIdentifier" value="forum_reply" />
	        <input type="hidden" name="ContentObjectID" value="{$child.contentobject_id}" />
                <input type="hidden" name="ContentNodeID" value="{$child.node_id}" />
                <input type="hidden" name="NodeID" value="{$child.node_id}" />
                <br /><input class="button forum-keep-me-updated" type="submit" name="ActionAddToNotification" value="{'Keep me updated'|i18n( 'design/base' )}" />
                <input name="ContentObjectLanguageCode" value="eng-GB" type="hidden" />

            </form>
	    </td>
   	    <td><p>{$child.object.data_map.message.content|simpletags|wordtoimage|autolink}</p></td>
            {/section}
	{/if}

	</tr></table> </li>{/if}

		    </ul>
                {section-else}
                     <p>{"There is no additional new content available. Apologies."|i18n("design/standard/content/newcontent")}</p>
                {/section}
		</ol>
            </div>

            {include name=navigator
                     uri='design:navigator/google.tpl'
                     page_uri='/discussion'
                     item_count=$list_count
                     view_parameters=$view_parameters
                     item_limit=$page_limit}
        {/let}
</div>
