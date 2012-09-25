{let subscribed_nodes=$handler.rules}

<div class="contentheader">
<h2>{"Node notification"|i18n("design/wiki/notification")}</h2>
</div>

<table class="list" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <th width="69%">
    {"Name"|i18n("design/wiki/notification")}
    </th>
    <th width="30%">
    {"Type"|i18n("design/wiki/notification")}
    </th>
    <th width="1%">
    {"Select"|i18n("design/wiki/notification")}
    </th>
</tr>

{section name=Rules loop=$subscribed_nodes sequence=array(bglight,bgdark)}
<tr class="{$Rules:sequence}">
    <td>
        <a href={concat("/content/view/full/",$Rules:item.node.node_id,"/")|ezurl}>{$Rules:item.node.name|wash}</a>
    </td>
    <td>
        {$Rules:item.node.object.content_class.name|wash}
    </td>

    <td>
          <input type="checkbox" name="SelectedRuleIDArray_{$handler.id_string}[]" value="{$Rules:item.id}" />
    </td>


</tr>
{/section}
</table>
<div class="buttonblock">
<input class="button" type="submit" name="NewRule_{$handler.id_string}" value="{'New'|i18n('design/wiki/notification')}" />
<input class="button" type="submit" name="RemoveRule_{$handler.id_string}" value="{'Remove'|i18n('design/wiki/notification')}" />
</div>

{/let}