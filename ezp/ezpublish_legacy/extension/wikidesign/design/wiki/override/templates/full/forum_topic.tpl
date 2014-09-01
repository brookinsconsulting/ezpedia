{let page_limit=20
     reply_limit=cond( $view_parameters.offset|gt( 0 ), 20,
                       19 )
     reply_offset=cond( $view_parameters.offset|gt( 0 ), sub( $view_parameters.offset, 1 ),
                        $view_parameters.offset )
     reply_list=fetch('content','list', hash( parent_node_id, $node.node_id,
                                              limit, $reply_limit,
                                              offset, $reply_offset,
                                              sort_by, array( array( published, false() ) ) ) )
     reply_count=fetch('content','list_count', hash( parent_node_id, $node.node_id ) )
     previous_topic=fetch_alias( subtree, hash( parent_node_id, $node.parent_node_id,
                                                class_filter_type, include,
                                                class_filter_array, array( 'forum_topic' ),
                                                limit, 1,
                                                attribute_filter, array( and, array( 'published', '<', $node.object.published ) ),
                                                sort_by, array( array( 'published', false() ) ) ) )
     next_topic=fetch_alias( subtree, hash( parent_node_id, $node.parent_node_id,
                                            class_filter_type, include,
                                            class_filter_array, array( 'forum_topic' ),
                                            limit, 1,
                                            attribute_filter, array( and, array( 'published', '>', $node.object.published ) ),
                                            sort_by, array( array( 'published', true() ) ) ) ) }


<div class="content-view-full">
    <div class="class-forum">

        <h1>{$node.name|wash}</h1>

        {section show=is_unset( $versionview_mode )}
        <div class="content-navigator">
            {section show=$previous_topic}
                <div class="content-navigator-previous">
                    <div class="content-navigator-arrow">&laquo;&nbsp;</div><a href={$previous_topic[0].url_alias|ezurl} title="{$previous_topic[0].name|wash}">{'Previous topic'|i18n( 'design/base' )}</a>
                </div>
            {section-else}
                <div class="content-navigator-previous-disabled">
                    <div class="content-navigator-arrow">&laquo;&nbsp;</div>{'Previous topic'|i18n( 'design/base' )}
                </div>
            {/section}

            {section show=$previous_topic}
                <div class="content-navigator-separator">|</div>
            {section-else}
                <div class="content-navigator-separator-disabled">|</div>
            {/section}

            {let forum=$node.parent}
                <div class="content-navigator-forum-link"><span><a href={$forum.url_alias|ezurl}>{$forum.name|wash}</a> for article <a href={$forum.parent.url_alias|ezurl}>{$forum.parent.name|wash}</a></span></div>
            {/let}

            {section show=$next_topic}
                <div class="content-navigator-separator">|</div>
            {section-else}
                <div class="content-navigator-separator-disabled">|</div>
            {/section}

            {section show=$next_topic}
                <div class="content-navigator-next">
                    <a href={$next_topic[0].url_alias|ezurl} title="{$next_topic[0].name|wash}">{'Next topic'|i18n( 'design/base' )}</a><div class="content-navigator-arrow">&nbsp;&raquo;</div>
                </div>
            {section-else}
                <div class="content-navigator-next-disabled">
                    {'Next topic'|i18n( 'design/base' )}<div class="content-navigator-arrow">&nbsp;&raquo;</div>
                </div>
            {/section}
        </div>

	<br />

        {section show=$node.object.can_create}
        <form method="post" action={"content/action/"|ezurl}>
            <input class="button forum-new-reply" type="submit" name="NewButton" value="{'New reply'|i18n( 'design/base' )}" />
            <input type="hidden" name="ContentNodeID" value="{$node.node_id}" />
            <input type="hidden" name="ContentObjectID" value="{$node.contentobject_id}" />
            <input class="button forum-keep-me-updated" type="submit" name="ActionAddToNotification" value="{'Keep me updated'|i18n( 'design/base' )}" />
            <input type="hidden" name="NodeID" value="{$node.node_id}" />
            <input type="hidden" name="ClassIdentifier" value="forum_reply" />
	    <input type="hidden" name="ContentLanguageCode" value="eng-GB" />
            <input name="ContentObjectLanguageCode" value="eng-GB" type="hidden" />
        </form>
        {section-else}
           <p>
            {"You need to be logged in to get access to the forums. You can do so"|i18n("design/base")} <a href={"/user/login/"|ezurl}>{"here"|i18n("design/base")}</a>
           </p>
        {/section}
        {/section}

        <div class="content-view-children">
            <table class="list forum" cellspacing="0">
            <tr>
                <th class="author">
                    {"Author"|i18n("design/base")}
                </th>
                <th class="message">
                    {"Message"|i18n("design/base")}
                 </th>
            </tr>


           {section var=reply loop=$reply_list sequence=array( bglight, bgdark )}
           <tr class="{$reply.sequence}"{* id="msg{$reply.object.id}" *}>
               <td class="author">
               {let owner=$reply.object.owner owner_map=$owner.data_map}
                   <p class="author">{$owner.name|wash}
                   {section show=is_set( $owner_map.title )}
                       <br/>{$owner_map.title.content|wash}
                   {/section}</p>

                   {section show=$owner_map.image.has_content}
                   <div class="authorimage" style="padding-top:15px;">
                      {attribute_view_gui attribute=$owner_map.image image_class=small}
                   </div>
                   {/section}

                   {* section show=is_set( $owner_map.location )}
                       <p>{"Location"|i18n( "design/base" )}: {$owner_map.location.content|wash}</p>
                   {/section *}

                   {let owner_id=$reply.object.owner.id}
                       {section var=author loop=$reply.object.author_array}
                           {section show=ne( $reply.object.owner_id, $author.contentobject_id )}
                               <p>
                                   {'Moderated by'|i18n( 'design/base' )}: {$author.contentobject.name|wash}
                               </p>
                           {/section}
                       {/section}
                   {/let}
               </td>
               <td class="message" id="msg{* $reply.object.id *}{$reply.node_id}">
                   <p class="date" style="padding-bottom:0px">{$reply.object.published|l10n( datetime )}

		   {if is_set( $reply.object.data_map.subject.content )}
                    - {$reply.object.data_map.subject.content|simpletags|wordtoimage|autolink}
                   {/if}

                   {switch match=$reply.object.can_edit}
                   {case match=1}
                       <div align="right" style="position:relative;top:-33px;"><form method="post" action={"content/action/"|ezurl}>
                       <input type="hidden" name="ContentObjectID" value="{$reply.object.id}" />
		       <input name="ContentObjectLanguageCode" value="eng-GB" type="hidden" />

                       <input style="font-size:0.7em;" class="button" type="submit" name="EditButton" value="{'Edit'|i18n('design/base')}" />
                       </form></div>
                   {/case}
                   {case match=0}
                   {/case}
                   {/switch}
		   </p>
                   <p style="margin:0em;margin-bottom:1em;">{$reply.object.data_map.message.content|simpletags|wordtoimage|autolink}</p>
                   {section show=$owner_map.signature.has_content}
                     <p class="author-signature">{$owner_map.signature.content|simpletags|autolink}</p>
                   {/section}
               {/let}
               </td>
           </tr>
           {/section}




            <tr>
               <td class="author">
               {let owner=$node.object.owner owner_map=$owner.data_map}
                   <p class="author">{$owner.name|wash}
                   {section show=is_set( $owner_map.title )}
                       <br/>{$owner_map.title.content|wash}
                   {/section}</p>
                   {section show=$owner_map.image.has_content}
                   <div class="authorimage">
                      {attribute_view_gui attribute=$owner_map.image image_class=small}
                   </div>
                   {/section}

                   {* section show=is_set( $owner_map.location )}
                       <p>{"Location"|i18n( "design/base" )}: {$owner_map.location.content|wash}</p>
                   {/section *}
                   <p>
                      {let owner_id=$node.object.owner_id}
                          {section var=author loop=$node.object.author_array}
                              {section show=eq($owner_id,$author.contentobject_id)|not()}
                                  {"Moderated by"|i18n( "design/base" )}: {$author.contentobject.name|wash}
                              {/section}
                          {/section}
                      {/let}
                   </p>

                  {* section show=$node.object.can_edit}
                      <form method="post" action={"content/action/"|ezurl}>
                          <input type="hidden" name="ContentObjectID" value="{$node.object.id}" />
			  <input name="ContentObjectLanguageCode" value="eng-GB" type="hidden" />
                          <input class="button forum-account-edit" type="submit" name="EditButton" value="{'Edit'|i18n('design/base')}" />
                      </form>
                  {/section *}
               </td>
               <td class="message" id="msg{* $node.object.id *}{$node.node_id}">
                   <p class="date">{$node.object.published|l10n(datetime)}

                   {if is_set( $node.object.data_map.subject.content )}
                    - {$node.object.data_map.subject.content|simpletags|wordtoimage|autolink}
                   {/if}

                   {switch match=$node.object.can_edit}
                   {case match=1}
                       <div align="right" style="position:relative;top:-33px;"><form method="post" action={"content/action/"|ezurl}>
                       <input type="hidden" name="ContentObjectID" value="{$node.object.id}" />
                       <input name="ContentObjectLanguageCode" value="eng-GB" type="hidden" />
                       <input style="font-size:0.7em;" class="button" type="submit" name="EditButton" value="{'Edit'|i18n('design/base')}" />
	               </form></div>
                   {/case}
                   {case match=0}
                   {/case}
                   {/switch}
		   </p>
                   <p>
                       {$node.data_map.message.content|simpletags|wordtoimage|autolink}
                   </p>
                   {section show=$owner_map.signature.has_content}
                       <p class="author-signature">{$owner_map.signature.content|simpletags|autolink}</p>
                   {/section}
               </td>
               {/let}
           </tr>
           {* Note: Uncertain I should have commented this out to stop a tpl section tag unexpected err,  /section *}


           </table>

        </div>

        {section show=is_unset( $versionview_mode )}
            {section show=$node.object.can_create}
            <form method="post" action={"content/action/"|ezurl}>
                <input class="button forum-new-reply" type="submit" name="NewButton" value="{'New reply'|i18n( 'design/base' )}" />
                <input type="hidden" name="ContentNodeID" value="{$node.node_id}" />
                <input type="hidden" name="ContentObjectID" value="{$node.contentobject_id}" />
                <input class="button forum-keep-me-updated" type="submit" name="ActionAddToNotification" value="{'Keep me updated'|i18n( 'design/base' )}" />
                <input type="hidden" name="NodeID" value="{$node.node_id}" />
                <input type="hidden" name="ClassIdentifier" value="forum_reply" />
  	        <input type="hidden" name="ContentLanguageCode" value="eng-GB" />
		<input name="ContentObjectLanguageCode" value="eng-GB" type="hidden" />
            </form>
            {section-else}
               <p>
                {"You need to be logged in to get access to the forums. You can do so"|i18n("design/base")} <a href={"/user/login/"|ezurl}>{"here"|i18n("design/base")}</a>
               </p>
            {/section}
        {/section}

    </div>
</div>

{include name=navigator
         uri='design:navigator/google.tpl'
         page_uri=$node.url_alias
         item_count=$reply_count
         view_parameters=$view_parameters
         item_limit=$page_limit}


