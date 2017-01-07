{* Folder - Full view *}
<div class="content-view-full">
    <div class="class-folder">

        <h1>{$node.data_map.name.content|wash()}</h1>

        {section show=$node.data_map.short_description.content.is_empty|not}
            <div class="attribute-short">
                {attribute_view_gui attribute=$node.data_map.short_description}
            </div>
        {/section}
        
{def $new=fetch('content', 'list',  hash( 'parent_node_id', 2,
                                               'sort_by', array( 'published', false() ),
                                               'limit',          4,
                                               'depth',          4
 ) )
}
{* <h2>Latest New</h2> *}

{if count($new)|gt(0)}
<ul class="item">
{foreach $new as $n}
    {* $n.object|attribute(show,1) *}
    <li><a href={$n.url_alias|ezurl}>{$n.name}</a><br />&nbsp;{$n.object.modified|datetime('custom', '%m/%d/%Y @ %G:%i')}</li>
    {* <td>{$n.count}</td> *}
{/foreach}
</ul>
{/if}
{undef}

        {section show=$node.data_map.description.content.is_empty|not}
            <div class="attribute-long">
                {attribute_view_gui attribute=$node.data_map.description}
            </div>
        {/section}

{def $updated=fetch('content', 'list',  hash( 'parent_node_id', 2,
                                               'sort_by', array( 'modified', false() ),
                                               'limit',          10,
                                               'depth',          4
 ) )
}
{* <h2>Latest Updated</h2> *}

{if count($updated)|gt(0)}
<ul class="item">
{foreach $updated as $u}
    {* $u.object|attribute(show,1) *}
    <li><a href={$u.url_alias|ezurl}>{$u.name}</a><br />&nbsp;{$u.object.modified|datetime('custom', '%m/%d/%Y @ %G:%i')}</li>
    {* <td>{$u.count}</td> *}
{/foreach}
</ul>
{/if}
{undef}

        


        {section show=is_unset( $versionview_mode )}
        {section show=$node.data_map.show_children.content}
            {let page_limit=10
                 list_items=array()
                 list_count=0}

            {section show=or( $view_parameters.day, $view_parameters.month, $view_parameters.year )}
                {let time_filter=array( and,
                                        array( 'published', '>=',
                                               maketime( 0, 0, 0,
                                                         $view_parameters.month, cond( $view_parameters.day, $view_parameters.day, 1 ), $view_parameters.year ) ),
                                        array( 'published', '<=',
                                               maketime( 23, 59, 59,
                                                         cond( $view_parameters.day, $view_parameters.month, $view_parameters.month|inc ), cond( $view_parameters.day, $view_parameters.day, 0 ), $view_parameters.year ) ) )}
                {set list_items=fetch_alias( children, hash( parent_node_id, $node.node_id,
                                                             offset, $view_parameters.offset,
                                                             attribute_filter, $time_filter,
                                                             sort_by, $node.sort_array,
                                                             limit, $page_limit ) )
                     list_count=fetch_alias( children_count, hash( parent_node_id, $node.node_id ) )}
                {/let}
            {section-else}
                {set list_items=fetch_alias( children, hash( parent_node_id, $node.node_id,
                                                             offset, $view_parameters.offset,
                                                             sort_by, $node.sort_array,
                                                             limit, $page_limit ) )}
                {set list_count=fetch_alias( children_count, hash( parent_node_id, $node.node_id ) )}
            {/section}

            <div class="content-view-children">
                {section var=child loop=$list_items sequence=array(bglight,bgdark)}
                    {node_view_gui view=line content_node=$child}
                {/section}
            </div>

            {include name=navigator
                     uri='design:navigator/google.tpl'
                     page_uri=$node.url_alias
                     item_count=$list_count
                     view_parameters=$view_parameters
                     item_limit=$page_limit}
            {/let}

        {/section}
        {/section}

    </div>
</div>
