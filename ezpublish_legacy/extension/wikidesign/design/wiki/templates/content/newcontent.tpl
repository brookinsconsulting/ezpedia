<div class="content-new">
    <h1>{"New content since last visit"|i18n("design/standard/content/newcontent")}</h1>
    <p>{"Your last visit to this site was"|i18n("design/standard/content/newcontent")}: {$last_visit_timestamp|l10n(datetime)}</p>
<style>
{literal}
div.break {
clear: none;
}
{/literal}
</style>
    {let page_limit=50
         list_items=array()
         list_count=0
         time_filter=array( array( 'modified', '>=', $last_visit_timestamp ) )}

        {set list_items=fetch( content, tree, hash( parent_node_id, 2,
                                                    offset, first_set( $view_parameters.offset, 0),
                                                    attribute_filter, $time_filter,
                                                    sort_by, array( array( 'modified', false() ) ),
                                                    limit, $page_limit ) )
             list_count=fetch( content, tree_count, hash( parent_node_id, 2,
                                                          offset, first_set( $view_parameters.offset, 0),
                                                          attribute_filter, $time_filter ) )}

            {include name=navigator
                     uri='design:navigator/google.tpl'
                     page_uri='/content/new'
                     item_count=$list_count
                     view_parameters=$view_parameters
                     item_limit=$page_limit}

            <div class="content-view-children" style="position:relative; top:-20%">
                {section var=child loop=$list_items show=$list_items sequence=array(bglight,bgdark)}
                    <div>{node_view_gui view=line content_node=$child}</div>
                {section-else}
                     <p>{"There is no new content since your last visit."|i18n("design/standard/content/newcontent")}</p>
                {/section}
            </div>

            {include name=navigator
                     uri='design:navigator/google.tpl'
                     page_uri='/content/new'
                     item_count=$list_count
                     view_parameters=$view_parameters
                     item_limit=$page_limit}
        {/let}
</div>
