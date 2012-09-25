{* Needed variables:
   - $nd
*}
{let $forum=false()
$default_language_id=false()
$default_language=ezini('RegionalSettings', 'Locale')
$current_user=fetch('user','current_user')
$userClass=fetch( 'content', 'class', hash( 'class_id', 4 ) )}
{if $current_user.is_logged_in}
{set $default_language_id=$current_user.contentobject.data_map.language.value.0}
{set $default_language=$userClass.data_map.language.content.options.$default_language_id}
{set $default_language=$default_language.name}
{/if}
{foreach $nd.children as $child}
{if array('forum_reply','forum_topic','forum')|contains( $child.object.class_identifier )}
{set $forum=$child}{break}
{/if}
{* set $forum=$child}{break *}
{/foreach}
<div class="menubox">
    <div class="menubox-title">{'This article'|i18n('design/wiki/pagelayout')}</div>
    <div class="menubox-content">
        <ul>
{if and( $current_user.is_logged_in, $default_language|ne('Disabled'), $default_language|ne('') )}
            <li><a href={concat("/content/edit/", $nd.contentobject_id, '/f/', $default_language)|ezurl}>{'Edit'|i18n('design/wiki/pagelayout')}</a></li>
{else}
            <li><a href={concat("/content/edit/", $nd.contentobject_id)|ezurl}>{'Edit'|i18n('design/wiki/pagelayout')}</a></li>
{/if}
{if and( $forum, $nd.children|count|gt( 0 ) )}
{if or( $forum.object.class_identifier|eq('wiki_article!'), and( $forum.object.class_identifier|eq('wiki_namespace!') ) )}

{* if or( $forum.object.class_identifier|eq('wiki_article!'), and( $forum.object.class_identifier|eq('wiki_namespace'), $forum.url|eq('ez') ) ) *}
{* def $discussion=fetch('content','list', hash( parent_node_id, $nd.node_id,
                                              'limit', 1,
                                              'sort_by', array( array( published, false() ) ),
					      'class_filter_type',  'include',
					      'class_filter_array', array( 'forum' )

 ) )}{*
            <li><a href={$discussion.0.url_alias|ezurl}>{'Discussion'|i18n('design/wiki/pagelayout')}</a>! {$discussion|attribute(show,1)}</li> *}
{else}
            <li><a href={$forum.url_alias|ezurl}>{'Discussion'|i18n('design/wiki/pagelayout')}</a></li>
{/if}
{/if}
            <li><a href={concat("/content/history/", $nd.contentobject_id)|ezurl}>{'History'|i18n('design/wiki/pagelayout')}</a></li>
            <li><a href={concat("/content/view/links/", $nd.node_id)|ezurl}>{'What links here'|i18n('design/wiki/pagelayout')}</a></li>
            <li><a href={concat("/notification/addtonotification/",$nd.node_id)|ezurl}>{'Keep me updated'|i18n('design/wiki/pagelayout')}</a></li>
        </ul>
    </div>
</div>
{/let}
