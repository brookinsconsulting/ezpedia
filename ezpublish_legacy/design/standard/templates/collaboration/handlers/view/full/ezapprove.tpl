{* DO NOT EDIT THIS FILE! Use an override template instead. *}
<form method="post" action={"collaboration/action/"|ezurl}>

{let message_limit=2
     message_offset=0
     content_version=fetch("content","version",hash("object_id",$collab_item.content.content_object_id,"version_id",$collab_item.content.content_object_version))
     current_participant=fetch("collaboration","participant",hash("item_id",$collab_item.id))
     participant_list=fetch("collaboration","participant_map",hash("item_id",$collab_item.id))
     message_list=fetch("collaboration","message_list",hash("item_id",$collab_item.id,"limit",$message_limit,"offset",$message_offset))}

{if $content_version|null()|not()}
  {set-block variable=contentobject_link}
    {content_version_view_gui view=text_linked content_version=$content_version}
  {/set-block}
{/if}

<table cellspacing="4" cellpadding="4" border="0">
<tr>
  <td rowspan="2" valign="top">

<div class="objectheader">
<h2>{"Approval"|i18n('design/standard/collaboration/approval')}</h2>
</div>

<div class="object">

{switch match=$collab_item.data_int3}
{case match=0}

{if $collab_item.is_creator}
<p>{"The content object %1 awaits approval before it can be published."|i18n('design/standard/collaboration/approval',,array($contentobject_link))}</p>
<p>{"Do you want to send a message to the person approving it?"|i18n('design/standard/collaboration/approval')}</p>
{else}
<p>{"The content object %1 needs your approval before it can be published."|i18n('design/standard/collaboration/approval',,array($contentobject_link))}</p>
<p>{"Do you approve of the content object being published?"|i18n('design/standard/collaboration/approval')}</p>
{/if}

{/case}
{case match=1}
  <p>{"The content object %1 was approved and will be published when the publishing workflow continues."|i18n('design/standard/collaboration/approval',,array($contentobject_link))}</p>
{/case}
{case in=array(2,3)}
  {if $collab_item.is_creator}
    <p>{"The content object %1 was not accepted but is still available as a draft."|i18n('design/standard/collaboration/approval',,array($contentobject_link))}</p>
    {if $content_version|null()|not()}
      <p>{"You may re-edit the draft and publish it, in which case an approval is required again."|i18n('design/standard/collaboration/approval')}</p>
      <p><a href={concat( "content/edit/", $content_version.contentobject_id, "/", $content_version.version )|ezurl}>{"Edit the object"|i18n('design/standard/collaboration/approval')}</a></p>
    {/if}
  {else}
    <p>{"The content object %1 was not accepted but will be available as a draft for the author."|i18n('design/standard/collaboration/approval',,array($contentobject_link))}</p>
    <p>{"The author can re-edit the draft and publish it again, in which case a new approval item is made."|i18n('design/standard/collaboration/approval')}</p>
  {/if}
{/case}
{case/}
{/switch}

<input type="hidden" name="CollaborationActionCustom" value="custom" />
<input type="hidden" name="CollaborationTypeIdentifier" value="ezapprove" />

<input type="hidden" name="CollaborationItemID" value="{$collab_item.id}" />

<br/>

{if eq($collab_item.data_int3,0)}
<label>{"Comment"|i18n('design/standard/collaboration/approval')}</label><div class="break"/>
<textarea name="Collaboration_ApproveComment" cols="40" rows="5"></textarea>

<div class="buttonblock">
<input type="submit" name="CollaborationAction_Comment" value="{'Add Comment'|i18n('design/standard/collaboration/approval')}" />

&nbsp;

{if $collab_item.is_creator|not}
<input type="submit" name="CollaborationAction_Accept" value="{'Approve'|i18n('design/standard/collaboration/approval')}" />
<input type="submit" name="CollaborationAction_Deny" value="{'Deny'|i18n('design/standard/collaboration/approval')}" />
{/if}
</div>
{/if}

</div>

  </td>

  <td rowspan="2" valign="top">

{if $content_version|null()|not()}
  {content_version_view_gui view=plain content_version=$content_version}
{/if}

  </td>

  <td rowspan="2" valign="top">

<div class="objectheader">
   <h2>{"Participants"|i18n('design/standard/collaboration/approval')}</h2>
</div>

<div class="object">
   {section name=Role loop=$participant_list}
   <label>{$:item.name|wash}</label>
   <table cellspacing="0" cellpadding="0" border="0">
   {section name=Participant loop=$:item.items}
   <tr>
     <td>
     {collaboration_participation_view view=text_linked collaboration_participant=$:item}
     </td>
   </tr>
   {/section}
   </table>
   {delimiter}<br/>{/delimiter}
   {/section}
</div>

  </td>

</tr>
</table>

{section show=$message_list}

  <h1 id="messages">{"Messages"|i18n('design/standard/collaboration/approval')}</h1>
  <table width="100%" cellspacing="0" cellpadding="4" border="0">
  {section name=Message loop=$message_list sequence=array(bglight,bgdark)}

      {collaboration_simple_message_view view=element sequence=$:sequence is_read=$current_participant.last_read|gt($:item.modified) item_link=$:item collaboration_message=$:item.simple_message}

  {/section}
  </table>

{/section}

{/let}

</form>