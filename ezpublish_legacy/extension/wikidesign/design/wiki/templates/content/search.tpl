{let use_template_search=true()
     search=false()}

{* <h1>{ezhttp('SearchPageLimit','get')}</h1> *}
{if ezhttp_hasvariable('SearchPageLimit','get')}
    {if ezhttp('SearchPageLimit','get')|eq(1)}
    	{set page_limit=5}
    {elseif ezhttp('SearchPageLimit','get')|eq(2)}
	{set page_limit=10}
    {elseif ezhttp('SearchPageLimit','get')|eq(3)}
	{set page_limit=20}
    {elseif ezhttp('SearchPageLimit','get')|eq(4)}
	{set page_limit=50}
    {else}
	{set page_limit=20}
    {/if}
{else}
    {set page_limit=20}
{/if}

{section show=$use_template_search}
    {set search=fetch(content,search,
                      hash(text,$search_text,
                           section_id,$search_section_id,
                           subtree_array,$search_subtree_array,
                           sort_by,array('modified',false()),
                           offset,$view_parameters.offset,
                           limit,$page_limit))}
    {set search_result=$search['SearchResult']}
    {set search_count=$search['SearchCount']}
    {set stop_word_array=$search['StopWordArray']}
    {set search_data=$search}
{/section}
{* $search_extras|attribute(show) *}
<div class="content-search">

<form action={"/content/search/"|ezurl} method="get">

<h1>{"Search"|i18n("design/base")}</h1>

<div>
    <input class="halfbox" type="text" size="20" name="SearchText" id="Search" value="{$search_text|wash}" />
    <input class="button" name="SearchButton" type="submit" value="{'Search'|i18n('design/base')}" />
</div>
<div>
{* def $currentLimitID=cond($page_limit|eq(50),5,$page_limit|eq(20),4,$page_limit|eq(20),3,$page_limit|eq(5),1,true(),2) *}
{def $currentLimitID=cond($page_limit|eq(50),4,$page_limit|eq(30),4,$page_limit|eq(20),3,$page_limit|eq(5),1,true(),2)}
{* def $currentLimitID=$page_limit *}
    <label for="SearchPageLimit">Results per page:</label> 
    <select name="SearchPageLimit" id="SearchPageLimit">
            <option value="1" {if $currentLimitID|eq(1)}selected="selected"{/if}>5</option>
	    <option value="2" {if $currentLimitID|eq(2)}selected="selected"{/if}>10</option>
	    <option value="3" {if $currentLimitID|eq(3)}selected="selected"{/if}>20</option>
	    <option value="4" {if $currentLimitID|eq(4)}selected="selected"{/if}>50</option>
    </select>
</div>
    {let adv_url=concat('/content/advancedsearch/',$search_text|count_chars()|gt(0)|choose('',concat('?SearchText=',$search_text|urlencode)))|ezurl}
    <label>{"For more options try the %1Advanced search%2"|i18n("design/base","The parameters are link start and end tags.",array(concat("<a href=",$adv_url,">"),"</a>"))}</label>
    {/let}

{section show=$stop_word_array}
    <p>
    {"The following words were excluded from the search"|i18n("design/base")}:
    {section name=StopWord loop=$stop_word_array}
        {$StopWord:item.word|wash}
        {delimiter}, {/delimiter}
    {/section}
    </p>
{/section}

{switch name=Sw match=$search_count}
  {case match=0}
  <div class="warning">
  <h2>{'No results were found when searching for "%1"'|i18n("design/base",,array($search_text|wash))}</h2>
  {if is_set($search_extras['LuceneError'])}
      {$search_extras['LuceneError']}
  {/if}
  </div>
    <p>{'Search tips'|i18n('design/base')}</p>
    <ul>
        <li>{'Check spelling of keywords.'|i18n('design/base')}</li>
        <li>{'Try changing some keywords eg. car instead of cars.'|i18n('design/base')}</li>
        <li>{'Try more general keywords.'|i18n('design/base')}</li>
        <li>{'Fewer keywords gives more results, try reducing keywords until you get a result.'|i18n('design/base')}</li>
    </ul>
  {/case}
  {case}
  <div class="feedback">
  <br />
  <h2>{'Search for "%1" returned %2 matches'|i18n("design/base",,array($search_text|wash,$search_count))}</h2>
  {* <p>Core search time: {$search_extras.ResponseHeader.QTime} msecs</p> *}
  </div>
  {/case}
{/switch}

{*
<h3>Categories matched</h3>
<p>
{foreach $search_extras.FacetArray.facet_fields.m_class_name as $keyword_name => $keyword_count}
{$keyword_name}({$keyword_count})&nbsp;
{/foreach}
</p>
*}

<table style="width: 100%;margin-bottom:2ex;margin-top:2ex;">
{section name=SearchResult loop=$search_result show=$search_result sequence=array('bglight','bgdark')}
<tr class="{$:sequence}">
   {node_view_gui view=search sequence=$:sequence content_node=$:item extras=$search_extras.DocExtras[$:item.node_id]}
</tr>
{/section}
</table>

{include name=Navigator
         uri='design:navigator/google.tpl'
         page_uri='/content/search'
         page_uri_suffix=concat('?SearchText=',$search_text|urlencode,$search_timestamp|gt(0)|choose('',concat('&SearchTimestamp=',$search_timestamp)),$currentLimitID|eq(2)|choose(concat('&SearchPageLimit=',$currentLimitID),''))
         item_count=$search_count
         view_parameters=$view_parameters
         item_limit=$page_limit}

{* include name=Navigator
         uri='design:navigator/alphabetical.tpl'
         page_uri='/content/search'
         page_uri_suffix=concat('?SearchText=',$search_text|urlencode,$search_timestamp|gt(0)|choose('',concat('&SearchTimestamp=',$search_timestamp)),$currentLimitID|eq(2)|choose(concat('&SearchPageLimit=',$currentLimitID),''))
         item_count=$search_count
         view_parameters=$view_parameters
         item_limit=$page_limit *}

</form>
</div>

{/let}
