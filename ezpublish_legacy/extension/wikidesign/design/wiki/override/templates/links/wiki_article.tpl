{* Links view *}
{default content_object=$node.object
         content_version=$node.contentobject_version_object
         node_name=$node.name|wash}

<div class="content-view-full">
    <div class="object">

    <h1><a href={$node.url_alias|ezurl}>{if $node.parent_node_id|ne(ezini('NamespaceSettings','DefaultNamespaceNodeID','wiki.ini'))}{$node.parent.name|wash}: {/if}{$node_name}</a></h1>
    <p>The following pages link to <a href={$node.url_alias|ezurl}>{if $node.parent_node_id|ne(ezini('NamespaceSettings','DefaultNamespaceNodeID','wiki.ini'))}{$node.parent.name|wash}: {/if}{$node_name}</a>:</p>

    {let $reverseRelatedObjects=fetch('content','reverse_related_objects',
                                      hash('object_id',$content_object.id,
                                           'all_relation',true(),
                                           'sort_by', array(array('name',true()))))}
    <ul>
    {foreach $reverseRelatedObjects as $reverseRelated}
        <li><a href={$reverseRelated.main_node.url_alias|ezurl}>{$reverseRelated.name|wash}</a>
    {/foreach}
    </ul>
    {/let}
    </div>{* class="object" *}
</div>{* class="content-view-full" *}

{/default}