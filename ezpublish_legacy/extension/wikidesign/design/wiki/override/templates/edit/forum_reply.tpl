{def $discardRedirectNode=fetch( 'content', 'node', hash( 'node_id', $main_node_id ) )}
{* $discardRedirectNode|attribute(show,1) *}

{* Forum reply - Edit *}

<div id="columns">
<div id="leftmenu">
    <div id="wiki_title">
        {include uri="design:page_logo.tpl"}
    </div>

    {include uri="design:menubox/edit.tpl"}
</div>

<div id="maincontent">
    <div id="maincontent-design">

    <div class="edit">
        <div class="class-forum-reply">
    
            <form enctype="multipart/form-data" method="post" action={concat( "/content/edit/", $object.id, "/", $edit_version, "/", $edit_language|not|choose( concat( $edit_language, "/" ), '' ) )|ezurl}>
    {* $object|attribute(show,1) 
    {$node|attribute(show,1)}
*}
{*            <h1>{$object.parent.name}</h1> *}
            <h2>{"Edit %1 - %2"|i18n("design/base",,array($class.name|wash,$object.name|wash))}</h2>
    
            {include uri="design:content/edit_validation.tpl"}

            <div style="display:none;">
                <input type="hidden" name="UseNodeAssigments" value="0" />
            </div>

            <input type="hidden" name="MainNodeID" value="{$main_node_id}" />
            {include uri="design:content/edit_attribute.tpl"}
            <br/>
    
            <div class="buttonblock">
                <input class="defaultbutton" type="submit" name="PublishButton" value="{'Send for publishing'|i18n('design/base')}" />
                <input class="button" type="submit" name="DiscardButton" value="{'Discard'|i18n('design/base')}" />
                <input type="hidden" name="DiscardConfirm" value="0" />
		<input type="hidden" name="RedirectURIAfterPublish" value="{$discardRedirectNode.url}" />
                <input type="hidden" name="RedirectIfDiscarded" value="{$discardRedirectNode.url}" />
            </div>
    
            </form>
        </div>
    </div>

    </div>
</div>

<div class="break"></div>

</div>
