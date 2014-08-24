{* let $langArray=cond(is_set( $langcode ), array( $langcode ), true(), false() )
     $articleCount=fetch( 'content', 'tree_count', hash(
    'parent_node_id', 2,
    'class_filter_type', 'include',
    'class_filter_array', array( 'wiki_article' ),
    'language', $langArray
    ))}
{$articleCount} {$content|wash}
{/let *}
{let $langArray=cond(is_set( $langcode ), array( $langcode ), true(), false() )
     $articleCount=fetch( 'content', 'list', hash(
    'parent_node_id', 2,
    'depth', 4
     ))}
{$articleCount|count}{$content}
{/let}