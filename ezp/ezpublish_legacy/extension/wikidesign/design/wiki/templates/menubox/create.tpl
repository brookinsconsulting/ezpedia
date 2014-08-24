{* Needed variables:
   - $parentClass
   - $createClassID
*}
{def $namespaces=fetch('content','list',hash('parent_node_id', 2,
                                             'class_filter_type', 'include',
                                             'class_filter_array', array( $parentClass ),
                                             'sort_by', array(array('priority',true()))))
     $canCreate=false()
     $canCreateNamespaces=array()}

{foreach $namespaces as $namespace}
    {def $canCreate=fetch( 'content', 'access', hash( 'access', 'create',
                                                     'contentobject', $namespace,
                                                     'contentclass_id', $createClassID ))}
    {if $canCreate}
    {set $canCreateNamespaces=$canCreateNamespaces|append($namespace)}
    {/if}
    {undef $canCreate}
{/foreach}

{if $canCreateNamespaces|count|gt(0)}
<div class="menubox">
    <div class="menubox-title">{'Create article'|i18n('design/wiki/pagelayout')}</div>
    <div class="menubox-content">
        <form method="post" action={'/content/action'|ezurl}>
	<label>{'Location:'|i18n('design/wiki/pagelayout')}</label><br />
        {* <label>{'Namespace:'|i18n('design/wiki/pagelayout')}</label> *}
        <input type="hidden" name="ClassID" value="{$createClassID}" />
        <select name="NodeID">
        {foreach $canCreateNamespaces as $namespace}
	 {if array( 'spotlight', 'template', 'snippets_for_ez_publish_3', 'historical', 'test_notifications', 'updated', 'new' )|contains( $namespace.url )|not}
            <option value="{$namespace.node_id}">{$namespace.name|wash}</option>
	 {/if}
        {/foreach}
        </select>
	<br />
        <input class="button" type="submit" name="NewButton" value="{'Create article'|i18n('design/wiki/pagelayout')}" />
        </form>
    </div>
</div>
{/if}

{undef $namespaces $canCreate}