{* Wiki article - Full view *}
{default content_object=$node.object
         content_version=$node.contentobject_version_object
         node_name=$node.name|wash
         node_url=$node.url|wash}
{def $children=fetch('content', 'list',  hash( 'parent_node_id', $node.node_id,
                                               'sort_by', $node.sort_array,
                                               'depth',          1
 ) )
}
{def $childrenCount=$children|count()}
<div class="content-view-full">
    <div class="class-wiki-namespace">
    {def $localrssUpdateInclusions=array( 'ez','solution','project','historical','updated', 'changelog', 'about', 'discussion', 'snippet', 'learning' )
         $localrssExclusions=array( 'minutes', 'help', 'people', 'f' )}

    {if $localrssUpdateInclusions|contains( $node_url )}
    <span class="rss-link" style="padding-right:08px"><a href="/rss/updated/{$node_url}"><img src={'images/icons/feed/feed-icon-28x28.png'|ezdesign} alt="ezpedia.org {$node_url} content rss feed" /></a></span> 
    {elseif $localrssExclusions|contains( $node_url )}
    
    {else}
    <span class="rss-link"><a href="/rss/feed/{$node_url}"><img src={'images/icons/feed/feed-icon-28x28.png'|ezdesign} alt="ezpedia.org {$node_url} new article rss feed" /></a></span>
    {/if}

    <h1>{$node_name}</h1>

    <p>{if $childrenCount|ne(0)}{$childrenCount} {/if}{if $node_name|ne("People")}Articles{else}People{/if} in this namespace{if $node_name|eq("People")}. Create your own personal page on eZpedia!{/if}{*:*}</p>
    <ul>
        {foreach $children as $child}
        <li><a href={$child.url_alias|ezurl}>{$child.name|wash}</a></li>
        {/foreach}
    </ul>

    </div>{* class="class-wiki-namespace" *}
</div>{* class="content-view-full" *}
{undef}
{/default}
