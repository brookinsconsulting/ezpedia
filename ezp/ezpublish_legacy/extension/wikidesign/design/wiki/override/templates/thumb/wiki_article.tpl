{* DO NOT EDIT THIS FILE! Use an override template instead. *}
{default node_name=$node.name|wash}<img src={"class_2.png"|ezimage} border="0" alt="{'Article'|i18n('design/wiki/node/view')}" />&nbsp;<a href={$node.url_alias|ezurl}>{if $node.parent_node_id|ne(ezini('NamespaceSettings','DefaultNamespaceNodeID','wiki.ini'))}{$node.parent.name|wash}: {/if}{$node_name}</a>{/default}