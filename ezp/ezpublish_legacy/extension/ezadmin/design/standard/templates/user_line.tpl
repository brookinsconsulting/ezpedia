{* DO NOT EDIT THIS FILE! Use an override template instead. *}
{default node_name=$node.name node_url=$node.url_alias}
<a href={$node.url_alias|ezurl} class="nodeicon" onclick="ezpopmenu_showTopLevel( event, 'SubitemsContextMenu', ez_createAArray( new Array( '%nodeID%', {$:node.node_id}, '%objectID%', {$:node.object.id} ) ) , '{$:node.object.name|shorten(18)|wash(javascript)}', {$:node.node_id} ); return false;">
{$node.class_identifier|class_icon( small, 'Click on the icon to get a context sensitive menu.'|i18n( 'design/admin/node/view/line' ) )}</a>&nbsp;
{section show=$node_url}<a href={$node_url|ezurl} title="{'Node ID: %node_id Visibility: %node_visibility'|i18n( 'design/admin/node/view/line',, hash( '%node_id', $node.node_id, '%node_visibility', $node.hidden_status_string ) )}">{/section}{$node_name|wash}{section show=$node_url}</a>{/section}{/default}
  <a href={concat( 'admin/changeuser/',$node.contentobject_id)|ezurl}><img style="width: 16 px;height:16px;" name="LoginButton" src={'current-user.gif'|ezimage} title="{'Login as user %1'|i18n( 'design/extension/ezadmin',,array( $node.name ) )}"></a>