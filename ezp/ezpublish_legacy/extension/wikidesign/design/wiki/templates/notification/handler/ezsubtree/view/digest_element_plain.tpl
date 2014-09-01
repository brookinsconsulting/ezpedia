{let content_object_version=fetch(notification,event_content,hash(event_id,$collection_item.event_id))}
{if $content_object_version.contentobject.main_node}

{$content_object_version.contentobject.name}: http://{ezini("SiteSettings","SiteURL")}{$content_object_version.contentobject.main_node.url_alias|ezurl(no)}

{/if}
{/let}
{* don't remove this break, it makes sure a new line will begin *}
