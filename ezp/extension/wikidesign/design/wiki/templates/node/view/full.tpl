{default content_object=$node.object
         content_version=$node.contentobject_version_object
         node_name=$node.name|wash}

<div class="object">
    <h1>{$node_name}</h1>

    {section name=ContentObjectAttribute loop=$content_version.contentobject_attributes}
    <div class="block">
        <label>{$ContentObjectAttribute:item.contentclass_attribute.name|wash}</label>
        <p class="box">{attribute_view_gui attribute=$ContentObjectAttribute:item}</p>
    </div>
    {/section}

    {if $node.children_count|gt(0)}
    <ul>
    {foreach $node.children as $child}
        <li><a href={$child.url_alias|ezurl}>{$child.name|wash}</a></li>
    {/foreach}
    </ul>
    {/if}
</div>

{/default}