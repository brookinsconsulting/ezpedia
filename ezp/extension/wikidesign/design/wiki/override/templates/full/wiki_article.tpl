{* Wiki article - Full view *}
{default content_object=$node.object
         content_version=$node.contentobject_version_object
         node_name=$node.name|wash
	 main_page_node_id=4408}
{def $previous_topic=fetch_alias( subtree, hash( parent_node_id, $node.parent_node_id,
                                                class_filter_type, include,
                                                class_filter_array, array( 'wiki_article' ),
                                                limit, 1,
                                                attribute_filter, array( and, array( 'name', '<', $node.name ) ),
                                                sort_by, array( array( 'name', false() ) ) ) )
     $next_topic=fetch_alias( subtree, hash( parent_node_id, $node.parent_node_id,
                                            class_filter_type, include,
                                            class_filter_array, array( 'wiki_article' ),
                                            limit, 1,
                                            attribute_filter, array( and, array( 'name', '>', $node.name ) ),
                                            sort_by, array( array( 'name', true() ) ) ) ) }
    <div class="class-wiki">{* <a href="{$prev}" style="text-decoration:none;color:#000000;">{$str_prev}</a> *}
{if $node.node_id|eq( $main_page_node_id )}
<h1>Welcome to <a href="/en/about/introduction" target="_self">eZpedia</a>!</h1>
{else}
<h1>{if $node.parent_node_id|ne(ezini('NamespaceSettings','DefaultNamespaceNodeID','wiki.ini'))}<a href={$node.parent.url|ezurl} class="class-namespace-link" style="text-decoration:none; color:#000000">{$node.parent.name|wash}</a>: {/if}<a href="/{$node.url}" style="text-decoration:none; color:#000000">{$node_name}</a></h1>
{/if}
{* <a href="{$next}" >{$str_next}</a> *}

{if $node.node_id|ne( $main_page_node_id )}
<div class="content-view-full">
        <div class="content-navigator" style="margin-bottom:+2px; margin-top:-20px; font-size: 1.0em; width:100%; " align="center">
            {section show=$previous_topic}
                <div class="content-navigator-previous">
                    <div class="content-navigator-arrow">&laquo;&nbsp;</div><a href={$previous_topic[0].url_alias|ezurl} title="{$previous_topic[0].name|wash}">{'Previous article'|i18n( 'design/base' )}</a>
                </div>
            {section-else}
                <div class="content-navigator-previous-disabled">
                    <div class="content-navigator-arrow">&laquo;&nbsp;</div>{'Previous article'|i18n( 'design/base' )}
                </div>
            {/section}

            {section show=$previous_topic}
                <div class="content-navigator-separator">|</div>
            {section-else}
                <div class="content-navigator-separator-disabled">|</div>
            {/section}

            {let forum=$node.parent}
                <div class="content-navigator-forum-link"><span><a href={$forum.url_alias|ezurl}>{$forum.name|wash}</a></span></div>
            {/let}

            {section show=$next_topic}
                <div class="content-navigator-separator">|</div>
            {section-else}
                <div class="content-navigator-separator-disabled">|</div>
            {/section}

            {section show=$next_topic}
                <div class="content-navigator-next">
                    <a href={$next_topic[0].url_alias|ezurl} title="{$next_topic[0].name|wash}">{'Next article'|i18n( 'design/base' )}</a><div class="content-navigator-arrow">&nbsp;&raquo;</div>
                </div>
            {section-else}
                <div class="content-navigator-next-disabled">
                    {'Next article'|i18n( 'design/base' )}<div class="content-navigator-arrow">&nbsp;&raquo;</div>
                </div>
            {/section}
        </div>
	{/if}

    {if $node.data_map.show_toc.data_int|eq(1)}
    {if is_set( $node.data_map.content)}
    <div class="toc">
    <p>Table of contents:</p>
    {eztoc( $node.data_map.content )}
    </div>
    {/if}
    {/if}

    <div class="attribute-long">
        {attribute_view_gui attribute=$node.data_map.content}
    </div>

    </div>{* class="class-wiki" *}
</div>{* class="content-view-full" *}

{/default}
