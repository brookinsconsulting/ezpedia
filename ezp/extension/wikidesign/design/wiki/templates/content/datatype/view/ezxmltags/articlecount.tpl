{let $langArray=cond(is_set( $langcode ), array( $langcode ), true(), false() )
     $articleCount=fetch( 'content', 'tree_count', hash(
    'parent_node_id', 2,
    'class_filter_type', 'include',
    'class_filter_array', array( 'wiki_article' ),
    'language', $langArray,
    'depth', 3
    ))}
{$articleCount} {$content|wash}
{/let}