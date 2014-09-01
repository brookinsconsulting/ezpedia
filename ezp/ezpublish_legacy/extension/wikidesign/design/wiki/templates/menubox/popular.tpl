<div class="menubox">
    <div class="menubox-title">{'Most popular'|i18n('design/wiki/pagelayout')}</div>
     <div class="menubox-content">
        <ul>
        {def $popular_nodes=fetch( 'content', 'view_top_list',
                           hash( 'class_id', 17,
                                 'limit', 20,
                                 'offset', 0 ) )}
        {foreach $popular_nodes as $popular_node}
            <li><a href={$popular_node.url_alias|ezurl}>{$popular_node.name|wash}</a> [{$popular_node.view_count}]</li>
        {/foreach}

        {undef $popular_nodes}
        </ul>
    </div>
</div>
