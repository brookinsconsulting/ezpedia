{default node_name=$node.name node_url=$node.url_alias}
{def $showLink=$node_url}
{if $node.object.content_class.is_container|not}
{set $showLink=false()}
{/if}
{$node.class_identifier|class_icon('small', $node.name)}&nbsp;{if $showLink}<a href={$node_url|ezurl}>{/if}{$node_name|wash}{if $showLink}</a>{/if}
{undef $showLink}
{/default}