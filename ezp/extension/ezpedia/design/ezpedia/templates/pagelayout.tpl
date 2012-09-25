{def $rssUpdateInclusions=array( 'ez','solution','project','historical','updated', 'changelog', 'about', 'discussion', 'snippet', 'learning' )
     $rssExclusions=array('main')}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
                      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$site.http_equiv.Content-language|wash}" lang="{$site.http_equiv.Content-language|wash}">
<head>


<style type="text/css">
    @import url({"stylesheets/core.css"|ezdesign});
    @import url({"stylesheets/site.css"|ezdesign});
    @import url({ezini('StylesheetSettings','SiteCSS','design.ini')|ezroot});
    @import url({"stylesheets/classes.css"|ezdesign});
    @import url({ezini('StylesheetSettings','ClassesCSS','design.ini')|ezroot});
    @import url({"stylesheets/debug.css"|ezdesign});
    {section var=css_file loop=ezini( 'StylesheetSettings', 'CSSFileList', 'design.ini' )}
        @import url({concat( 'stylesheets/', $css_file )|ezdesign});
    {/section}
</style>

{def $openSearchDescriptions=ezini('OpenSearchSettings','DescriptionList','opensearch.ini')}
    {foreach $openSearchDescriptions as $searchIdentifier}
    {def $blockName=concat('OpenSearch_', $searchIdentifier)
         $url=ezini($blockName, 'URL', 'opensearch.ini')
         $title=ezini($blockName, 'Title', 'opensearch.ini')}
    <link rel="search" type="application/opensearchdescription+xml" title="{$title|wash}" href="{$url}" />
    {undef $url $title $blockName}
    {/foreach}
{undef $openSearchDescriptions}

{def $rssList=fetch('rss','list')}
{foreach $rssList as $rss}
{if and( $rssUpdateInclusions|contains( $rss.access_url ), $rssExclusions|contains( $rss.access_url )|not )}
<link rel="alternate" type="application/rss+xml" title="{$rss.title|wash}" href={concat("/rss/updated/",$rss.access_url)|ezurl} />
{else}
{if $rssExclusions|contains( $rss.access_url )|not}<link rel="alternate" type="application/rss+xml" title="{$rss.title|wash}" href={concat("/rss/feed/",$rss.access_url)|ezurl} />{/if}{/if}
{/foreach}
{undef $rssList}

{* BC: Google Sitemap verifiy meta tag for webmaster tools aka sitemap submission for ezpedia.org site *}
<meta name="verify-v1" content="uOqfIe9V7lA3f6J2IBorxWguZry2qShFFUVs4fVxOiU=" />

{section name=JavaScript loop=ezini( 'JavaScriptSettings', 'JavaScriptList', 'design.ini' ) }
    <script type="text/javascript" src={concat( 'javascript/',$:item )|ezdesign}></script>
{/section}

{literal}
<!--[if lt IE 6.0]>
<style>
div#maincontent-design { width: 100%; } /* This is needed to avoid width bug in IE 5.5 */
</style>
<![endif]-->
<!--[if lt IE 7.0]>
<style>
.menubox-content input.button, .menubox-content input.defaultbutton, ..menubox-content select { font-size: 0.9em }
.menubox-content form { padding:0; margin:0 }
</style>
<![endif]-->
{/literal}

{include uri="design:page_head.tpl"}

</head>
<body>

<!--

navigation part: {$module_result.navigation_part}
ui_context: {$ui_context}
ui_component: {$ui_component}

-->

<div id="allcontent">

    <div id="topmenu">
        {include uri="design:page_top.tpl"}
    </div>

    <div id="columns">
    {* <p>Component: {$ui_component}, Context: {$ui_context}</p> *}
    {*
    {section show=or( and( eq( $ui_component, 'content' ), eq( $ui_context, 'edit' ) ) )}
    {section show=false()}
    *}

    {let $module_params=$module_params}
    {section show=or( and( eq( $ui_component, 'content' ), eq( $ui_context, 'edit' ), eq( array('edit')|contains( $module_params.function_name )
), $module_result.path.0.text|ne( 'History' )  ) )}
    {* $module_result.path.0|attribute(show,1) *}
      {$module_result.content}
    {section-else}
    <div id="leftmenu">
        <div id="leftmenu-design">
{*            <div id="wiki_title" style="position:relative;top:-20px;">
            <div id="wiki_title" style="position:absolute;top: 3px; left: 4px;">
            <div id="wiki_title" style="position:absolute; top:3px; right: 4px;">
            <div id="wiki_title" style="position:absolute;top:43px;right:20px;">
*}
            <div id="wiki_title" style="position:relative; top: -3px; left: 4px; margin-bottom: 0.45em;">
                {include uri="design:page_logo.tpl"}
            </div>
	    {* $module_result|attribute(show,1) *}
	    {* <h1>{$module_result.navigation_part}</h1> *}


            {if eq( $ui_context, 'browse' )}
                {* do nothing for now *}
            {elseif and( array('ezcontentnavigationpart','ezmedianavigationpart')|contains($module_result.navigation_part), is_set( $module_result.node_id )|not )}
	        {include uri="design:menubox/namespaces.tpl"}
	        {* if is_set( $module_result.node_id )}
                  {include uri="design:menubox/article.tpl" object=fetch( 'content', 'node', hash( 'node_id', $module_result.node_id ) )}
	        {/if *}

	        {* $module_result.path.0|attribute(show,1)}
	        {$module_result|attribute(show,1) *}

                {if and(
	        array( 'notification', 'error', 'content' )|contains( $module_result.ui_component ),
	        array( 'Search', 'Error', 'History' )|contains( $module_result.path.0.text )
	        )}{include uri="design:menubox/search.tpl"}{/if}

	        {include uri="design:menubox/create.tpl" parentClass='wiki_namespace' createClassID=17}
	        {include uri="design:menubox/popular.tpl"}
	        {include uri="design:menubox/users.tpl"}
            {elseif and( array('ezcontentnavigationpart','ezmedianavigationpart')|contains($module_result.navigation_part), is_set( $module_result.node_id ))}
	        {* include uri="design:menubox/namespaces.tpl" *}
                {include uri='design:menu/content.tpl' nd_id=$module_result.node_id}
            {elseif eq($module_result.navigation_part,'ezcontentnavigationpart')}
                {let $module_params=$module_params}
                {if and( $module_params.module_name|eq( 'notification', 'content' ), array('addtonotification','search','advancedsearch','diff','history')|contains($module_params.function_name))}
                    {let $object=fetch('content','object',hash('object_id',$module_params.parameters.ObjectID))}
                      {include uri='design:menu/content.tpl' nd_id=$object.main_node_id}
                    {/let}
                {else}
                    {include uri='design:menu/search.tpl'}
                {/if}
                {/let}
            {else}
	        {include uri="design:menubox/namespaces.tpl"}
	        {include uri="design:menubox/search.tpl"}
	        {include uri="design:menubox/create.tpl" parentClass='wiki_namespace' createClassID=17}
                {let $rootNode=fetch('content','node', hash('node_id', 4408 ) )}
	            {include uri="design:menubox/translations.tpl" object=$rootNode.object}
                {/let}
	        {include uri="design:menubox/popular.tpl"}
                {include uri="design:menubox/users.tpl"}
            {/if}
        </div>
    </div>

    <div id="maincontent">
        <div id="maincontent-design">
        {$module_result.content}
        </div>
    </div>

    <div class="break"></div>
    {/section}
    {/let}

    </div>{* ID=columns *}


    <div id="footer">
        {include uri="design:page_copyright.tpl"}
    </div>

</div>{* id="allcontent" *}

<!--DEBUG_REPORT-->

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
{literal}
try{
var pageTracker = _gat._getTracker("UA-2563085-1");
pageTracker._trackPageview();
} catch(err) {}
{/literal}
</script></body>
</html>
