{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h4>{'Admin menu'|i18n( 'design/admin/parts/visual/menu' )}</h4>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">


  <ul>
    <li><div><a href={"/admin/sqlquery"|ezurl}>SQL Manager</a></div></li>
    {*<li><div><a href={"/admin/backup"|ezurl}>Backup</a></div></li>*}
    <li><div><a href={"/admin/frame/admin/phpinfo"|ezurl}>PHP Information</a></div></li>
    <li><div><a href={"/admin/changeuserview"|ezurl}>User Change</a></div></li>
   {if function_exists('apc_add')}
    <li><div><a href={"/admin/frame/admin/apc/"|ezurl}>APC Control Interface</a></div></li>
   {/if}
   {if function_exists('eaccelerator_get')}
    <li><div><a href={"/admin/frame/admin/eaccelerator/"|ezurl}>eAccelerator Control Interface</a></div></li>
   {/if}
{def $access=fetch( 'user', 'has_access_to',
                    hash( 'module',   'svn',
                          'function', 'client' ) )}
 
{if $access}
    <li><div><a href={"/svn/client"|ezurl}>SVN Client</a></div></li>
{/if}
    <li><div><a href={"/admin/client"|ezurl}>SOAP test Client</a></div></li>
    <li><div><a href={"/admin/mailtest"|ezurl}>Mail test</a></div></li>
  </ul>

{* DESIGN: Content END *}</div></div></div></div></div></div>

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h4>{'User change'|i18n( 'ezadmin' )}</h4>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">

<ul>
    <li><div><a href={'admin/recalluser'|ezurl}>{'Recall original user'|i18n( 'ezxnewsletter' )}</a></div></li>
</ul>

{* DESIGN: Content END *}</div></div></div></div></div></div>
