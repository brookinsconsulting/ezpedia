{def $pagedesign=fetch_alias(by_identifier,hash('attr_id','sitestyle_identifier'))}
{if $pagedesign.data_map.image.content.is_valid}
    <a href={"/"|ezurl}><img id="pagelogoimg" style="" src={$pagedesign.data_map.image.content[original].full_path|ezroot} alt="{$pagedesign.data_map.image.content[original].text}" title="{$pagedesign.data_map.image.content[original].text}" border="0" /></a>
    <h1><a href={"/"|ezurl}><span class="hide">eZpedia - The eZ Publish Documentation Encyclopedia</span></a></h1>
{else}
    <h1><a href={"/"|ezurl}>{ezini('SiteSettings','SiteName')}</a></h1>
    <h1><a href={"/"|ezurl}><span class="hide">eZpedia - The eZ Publish Documentation Encyclopedia</span></a></h1>
{/if}
{undef $pagedesign}