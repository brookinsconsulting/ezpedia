{include uri="design:menubox/namespaces.tpl"}

{let $nd=fetch( 'content', 'node', hash( 'node_id', $nd_id ) )}

{include uri="design:menubox/search.tpl"}

{include uri="design:menubox/create.tpl" parentClass='wiki_namespace' createClassID=17}

{include uri="design:menubox/article.tpl" nd=$nd}

{include uri="design:menubox/info.tpl" object=$nd}

{include uri="design:menubox/translations.tpl" object=$nd.object}

{include uri="design:menubox/popular.tpl"}

{include uri="design:menubox/users.tpl"}
{/let}