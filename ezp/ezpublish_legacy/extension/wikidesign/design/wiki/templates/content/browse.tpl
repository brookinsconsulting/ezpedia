{let browse_indentation=5
     page_limit=15
     browse_list_count=fetch(content,list_count,hash(parent_node_id,$node_id,depth,1))
     object_array=fetch(content,list,hash(parent_node_id,$node_id,depth,1,offset,$view_parameters.offset,limit,$page_limit,objectname_filter,$view_parameters.namefilter,sort_by,$main_node.sort_array))
     bookmark_list=fetch('content','bookmarks',array())
     recent_list=fetch('content','recent',array())

     select_name='SelectedObjectIDArray'
     select_type='checkbox'
     select_attribute='contentobject_id'
     classIDList=array() }

{foreach $browse.class_array as $classIdentifier}
 {def $class=fetch('content', 'class', hash( 'class_id', $classIdentifier ))}
   {set $classIDList=$classIDList|append($class.id)}
 {undef $class}
{/foreach}

{section show=eq($browse.return_type,'NodeID')}
    {set select_name='SelectedNodeIDArray'}
    {set select_attribute='node_id'}
{/section}
{section show=eq($browse.selection,'single')}
    {set select_type='radio'}
{/section}


{let search=false()
     search_text=false()
     search_count=false()
     search_result=false()
     search_data=false()
     stop_word_array=false()
     page_limit=20 }

{if ezhttp('SearchText', 'get')|ne('')}
{set search_text=ezhttp('SearchText', 'get')}
{/if}

{* def $na=fetch( 'content', 'node', hash( node_id, $node_id, limit, $page_limit ) )}
{if and( ezhttp('SearchText', 'get')|eq(''), is_set( $na ) )}
{set search_text=$na.name}
{/if}
{$na|attribute(show,1) *}

    {if is_array($browse.class_array)}
    {set search=fetch(content,search,
                      hash(text,$search_text,
                           section_id,$search_section_id,
                           subtree_array,$search_subtree_array,
               class_id, $classIDList,
                           offset,$view_parameters.offset,
                           objectname_filter,$view_parameters.namefilter,
                           limit,$page_limit))}
    {else}
    {set search=fetch(content,search,
                      hash(text,$search_text,
                           section_id,$search_section_id,
                           subtree_array,$search_subtree_array,
                           offset,$view_parameters.offset,
                           objectname_filter,$view_parameters.namefilter,
                           limit,$page_limit))}
    {/if}
    {set search_result=$search['SearchResult']}
    {set search_count=$search['SearchCount']}
    {set stop_word_array=$search['StopWordArray']}
    {set search_data=$search}

<h1 class="context-title">{'Search'|i18n( 'design/wiki/content/search' )}</h1>

<form  method="get" action={'/content/browse/'|ezurl}>

<div class="block">
    <input class="halfbox" type="text" name="SearchText" id="Search" value="{$search_text|wash}" />
    <input class="button"  name="SearchButton" type="submit" value="{'Search'|i18n( 'design/wiki/content/browse' )}" />
    <input type="hidden" name="SearchBrowser" id="Search" value="1" />
</div>

</form>

<form method="post" action={$browse.from_page|ezurl}>

{* Excluded words. *}
{section show=$stop_word_array}
<p>
{'The following words were excluded from the search'|i18n( 'design/wiki/content/browse' )}:
{section name=StopWord loop=$stop_word_array}
    {$StopWord:item.word|wash}
    {delimiter}, {/delimiter}
{/section}
</p>
{/section}

{* No matches. *}
{section show=and($search_count|not, ne($search_text, '')) }
<h2>{'No results were found while searching for <%1>'|i18n( 'design/wiki/content/search',, array( $search_text ) )|wash}</h2>
    <p>{'Search tips'|i18n( 'design/wiki/content/search' )}</p>
    <ul>
        <li>{'Check spelling of keywords.'|i18n( 'design/wiki/content/search', 'test' )}</li>
        <li>{'Try changing some keywords e.g. car instead of cars.'|i18n( 'design/wiki/content/search' )}</li>
        <li>{'Try more general keywords.'|i18n( 'design/wiki/content/search' )}</li>
        <li>{'Fewer keywords gives more results, try reducing keywords until you get a result.'|i18n( 'design/wiki/content/search' )}</li>
    </ul>
{/section}

</div>

{* Search result. *}
{section show=$search_count}
<p>{'Search for <%1> returned %2 matches'|i18n( 'design/wiki/content/search',, array( $search_text, $search_count ) )|wash}</p>

<table class="list" cellspacing="0">
<tr>
    <th width="1">
    </th>
    <th width="69%">
    {"Name"|i18n("design/wiki/content/browse")}
    </th>
    <th width="30%" class="class">
    {"Class"|i18n("design/wiki/content/browse")}
    </th>
</tr>
{section loop=$search_result sequence=array( bglight, bgdark )}
  <tr class="{$:sequence}">
    <td>
     <input type="{$select_type}" name="{$select_name}[]" value="{$item[$select_attribute]}" />
     </td>
     <td>
     {$item.object.class_identifier|class_icon( small, $item.object.class_name )}&nbsp;{$item.name|wash}
    </td>
    <td  class="class">
     {$item.object.content_class.name|wash}
    </td>
</tr>
{/section}
</table>


<div>
{include name=Navigator
         uri='design:navigator/alphabetical.tpl'
         page_uri='/content/browse'
         page_uri_suffix=concat( '?SearchText=', $search_text|urlencode, $search_timestamp|gt( 0 )|choose( '', concat( '&SearchTimestamp=', $search_timestamp ) ) )
         item_count=$search_count
         view_parameters=$view_parameters
         item_limit=$page_limit}
</div>

{section name=Persistent show=$browse.persistent_data loop=$browse.persistent_data}
    <input type="hidden" name="{$:key|wash}" value="{$:item|wash}" />
{/section}

<div class="block">
    <input type="hidden" name="BrowseActionName" value="{$browse.action_name}" />
    <input class="button" type="submit" name="SelectButton" value="{'OK'|i18n( 'design/wiki/content/browse' )}" />
    <input class="button" type="submit" name="BrowseCancelButton" value="{'Cancel'|i18n( 'design/wiki/content/browse' )}" />
</div>


{/section}
</form>

{/let}

<form action={concat($browse.from_page)|ezurl} method="post">

{section show=$browse.description_template}
    {include name=Description uri=$browse.description_template browse=$browse main_node=$main_node}
{section-else}
    <div class="maincontentheader">
    <h1>{"Browse"|i18n("design/wiki/content/browse")} - {$main_node.name|wash}</h1>
    </div>

    <p>{'To select objects, choose the appropriate radiobutton or checkbox(es), and click the "Select" button.'|i18n("design/wiki/content/browse")}</p>
    <p>{'To select an object that is a child of one of the displayed objects, click the object name and you will get a list of the children of the object.'|i18n("design/wiki/content/browse")}</p>
{/section}

        {* Browse listing start *}
        <table class="list" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <th width="1">
            </th>
            <th width="69%">
            {"Name"|i18n("design/wiki/content/browse")}
            </th>
            <th width="30%">
            {"Class"|i18n("design/wiki/content/browse")}
            </th>
            <th width="30%">
            {"Section"|i18n("design/wiki/content/browse")}
            </th>
        </tr>
        <tr>
            <td class="bglight">
            {section show=and( or( $browse.permission|not,
                                   cond( is_set( $browse.permission.contentclass_id ),
                                         fetch( content, access,
                                                hash( access, $browse.permission.access,
                                                      contentobject, $main_node,
                                                      contentclass_id, $browse.permission.contentclass_id ) ),
                                         fetch( content, access,
                                                hash( access, $browse.permission.access,
                                                      contentobject, $main_node ) ) ) ),
                               $browse.ignore_nodes_select|contains( $main_node.node_id )|not() )}
          {section show=is_array($browse.class_array)}
            {section show=$browse.class_array|contains($main_node.object.content_class.identifier)}
          <input type="{$select_type}" name="{$select_name}[]" value="{$main_node[$select_attribute]}" {section show=eq($browse.selection,'single')}checked="checked"{/section} />
        {section-else}
            &nbsp;
        {/section}
          {section-else}
            <input type="{$select_type}" name="{$select_name}[]" value="{$main_node[$select_attribute]}" {section show=eq($browse.selection,'single')}checked="checked"{/section} />
          {/section}
        {section-else}
            &nbsp;
            {/section}
            </td>

            <td class="bglight">
{*                 {node_view_gui view=browse_line content_node=$main_node node_url=concat( 'content/browse', $main_node.parent_node_id, '/' )} *}
                {node_view_gui view=browse_line content_node=$main_node node_url=false()}
                {section show=and($main_node.depth|gt(1),$main_node.node_id|ne(ezini('NodeSettings','RootNode','content.ini')))}
                    <a href={concat("/content/browse/",$main_node.parent_node_id,"/")|ezurl}>
                        [{'Up one level'|i18n('design/wiki/content/browse')}]
                    </a>
                {/section}
            </td>

            <td class="bglight">
            {$main_node.object.content_class.name|wash}
            </td>

            <td class="bglight">
            {$main_node.object.section_id}
            </td>
        </tr>
        {section name=Object loop=$object_array sequence=array(bgdark,bglight)}
        <tr class="{$Object:sequence}">
            <td>
            {section show=and( or( $browse.permission|not,
                                   cond( is_set( $browse.permission.contentclass_id ),
                                         fetch( content, access,
                                                hash( access, $browse.permission.access,
                                                      contentobject, $:item,
                                                      contentclass_id, $browse.permission.contentclass_id ) ),
                                         fetch( content, access,
                                                hash( access, $browse.permission.access,
                                                      contentobject, $:item ) ) ) ),
                               $browse.ignore_nodes_select|contains($:item.node_id)|not() )}
              {section show=is_array($browse.class_array)}
                {section show=$browse.class_array|contains($:item.object.content_class.identifier)}
                  <input type="{$select_type}" name="{$select_name}[]" value="{$:item[$select_attribute]}" />
                {section-else}
                  &nbsp;
                {/section}
              {section-else}
                <input type="{$select_type}" name="{$select_name}[]" value="{$:item[$select_attribute]}" />
              {/section}
            {/section}
            </td>

            <td>
                <img src={"1x1.gif"|ezimage} width="{mul(sub($:item.depth,$main_node.depth),$browse_indentation)}" height="1" alt="" border="0" />

                 {node_view_gui view=browse_line content_node=$Object:item node_url=cond( $browse.ignore_nodes_click|contains($Object:item.node_id)|not(), concat( 'content/browse/', $Object:item.node_id, '/' ), false() )}
            </td>

            <td>
                    {$Object:item.object.content_class.name|wash}
            </td>

            <td>
                    {$:item.object.section_id}
            </td>
        </tr>
        {/section}
        </table>
        {* Browse listing end *}

{include name=Navigator
         uri='design:navigator/alphabetical.tpl'
         page_uri=concat('/content/browse/',$main_node.node_id)
         item_count=$browse_list_count
         view_parameters=$view_parameters
         item_limit=$page_limit}


{section name=Persistent show=$browse.persistent_data loop=$browse.persistent_data}
    <input type="hidden" name="{$:key|wash}" value="{$:item|wash}" />
{/section}

<input type="hidden" name="BrowseActionName" value="{$browse.action_name}" />
{section show=$browse.browse_custom_action}
<input type="hidden" name="{$browse.browse_custom_action.name}" value="{$browse.browse_custom_action.value}" />
{/section}

<input class="button" type="submit" name="SelectButton" value="{'Select'|i18n('design/wiki/content/browse')}" />


{section show=$cancel_action}
<input type="hidden" name="BrowseCancelURI" value="{$cancel_action}" />
{/section}
 <input class="button" type="submit" name="BrowseCancelButton" value="{'Cancel'|i18n( 'design/wiki/content/browse' )}" />
</form>
{/let}