{def $feedurl0="http://github.com/ezsystems/ezpublish/commits/master.atom"
     $feedresults=array()
     $issue=false()}
{set $feedresults=fetchxml( $feedurl, true(), false() )}
{* $feedresults|attribute(show,1) *}

  <div class="content-view-children" style="padding-left: 1.37%; padding-bottom: 10px;">

   <span class="rss-link"><a href="{$feedurl}"><img src={'images/icons/feed/feed-icon-16x16.png'|ezdesign} alt="ezpedia.org discussions rss feed"/></a></span>

    <div style="font-size: xx-small; padding-bottom:8px;">Last updated: {$feedresults.0.updated}</div>

    {* section var=child loop=$list_items show=$list_items sequence=array(bglight,bgdark) *}

    {section var=child loop=$feedresults show=$feedresults sequence=array(bglight,bgdark) max=$limit}
    {* $child|attribute(show,1) *}

    {if $child.title|ne('')}
    <div style="list-style-type: none;font-size: xx-small; padding-bottom:4px;">
     <div style="list-style-type: none;font-size: xx-small;margin-top:10px;">
     <a style="font-size: small" href={concat( $child.link, '')}>{$child.title|wash}</a></div>
     <span style="font-size: xx-small;"> 
	  {set $issue=wrap_user_func('getIssueFromWebSVNSubversionCommitMessage', array( $child.title ) )}
          {if $issue|ne('')}<div align="right" style="margin-right:4%; position:relative; top:+07px;"><span style="text-decoration: underline; font-weight: bold; font-size: small; color: #00000;"><a href="http://issues.ez.no/{$issue}">Related issue</a></span><span style="font-size:xx-small">:</span><br /><span style="font-size:small; font-weight:bold;"> <a href="http://issues.ez.no/{$issue}"><img src="{"images/icons/issue/issue.png"|ezdesign('no')}" border="0" height="15" width="16" />&nbsp;{$issue}</a></span></div>{/if}
          <span style="font-size: xx-small">{$child.updated}</span>
          <span style="font-size: xx-small">{$child.content}</span>
     </span>
     </div>
     {/if}
     {section-else}
       <p>{"Sorry there is no content available."|i18n("design/standard/content/newcontent")}</p>
     {/section}
   </div>