{default $current_user=fetch('user','current_user')}
{def $forum=false()
$default_language_id=false()
$default_language=ezini('RegionalSettings', 'Locale')
$userClass=fetch( 'content', 'class', hash( 'class_id', 4 ) )}
{if $current_user.is_logged_in}
{set $default_language_id=$current_user.contentobject.data_map.language.value.0}
{set $default_language=$userClass.data_map.language.content.options.$default_language_id}
{set $default_language=$default_language.name}
{/if}
{* $current_user.contentobject.data_map.language.value|attribute(show,1)}
{$userClass.data_map.language.content.options.$default_language_id|attribute(show,1) *}
{if is_set( $module_result.node_id )}
{def $page=fetch( 'content', 'node', hash( 'node_id', $module_result.node_id ) )}
{/if}

<ul>
{if $current_user.is_logged_in}
    <li><a href={"/user/logout"|ezurl}>{"Log out"|i18n("design/wiki/pagelayout")} ({$current_user.contentobject.name|wash})</a></li>
    <li><a href={"/users"|ezurl}>{"Users"|i18n("design/wiki/pagelayout")}</a></li>
    <li><a href={concat("/layout/set/print/", $page.url )|ezurl}>{"Printable"|i18n("design/wiki/pagelayout")}</a></li>
    <li><a href={"/content/draft"|ezurl}>{"Drafts"|i18n("design/wiki/pagelayout")}</a></li>
    <li><a href={"/notification/settings"|ezurl}>{"Notifications"|i18n("design/wiki/pagelayout")}</a></li>
    {* <li><a href={concat("/content/edit/",$current_user.contentobject_id)|ezurl}>{"Change profile"|i18n("design/wiki/pagelayout")}</a></li> *}
    {if and( $default_language|ne('Disabled'), $default_language|ne('') )}
    <li><a href={concat("/content/edit/",$current_user.contentobject_id, '/f/', $default_language)|ezurl}>{"Change profile"|i18n("design/wiki/pagelayout")}</a></li>
    {else}
    <li><a href={concat("/content/edit/",$current_user.contentobject_id)|ezurl}>{"Change profile"|i18n("design/wiki/pagelayout")}</a></li>
    {/if}
{else}
    <li><a href={"/user/login"|ezurl}>{"Log in"|i18n("design/wiki/pagelayout")}</a></li>
    <li><a href={"/user/register"|ezurl}>{"Create account"|i18n("design/wiki/pagelayout")}</a></li>
    <li><a href={"/user/forgotpassword"|ezurl}>{"Forgot your password?"|i18n( "design/standard/user" )}</a></li>
    <li><a href={"/content/view/sitemap/2"|ezurl}>{"Sitemap"|i18n("design/wiki/pagelayout")}</a></li>

    {* For Privacy of users I have disabled this navigation element, <li><a href={"/users"|ezurl}>{"Users"|i18n("design/wiki/pagelayout")}</a></li> *}
{/if}
</ul>
{/default}
