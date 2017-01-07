{* Wiki article - Embed view *}
{def $link=concat('<a href=' , $object.main_node.url_alias|ezurl, '>', $object.name|wash, '</a>')}
{ezstr_replace('[LINK]',$link,$object.data_map.content.content.output.output_text)}
{undef $link}