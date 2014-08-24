{if and( is_set( $align )|eq( true() ), is_set( $size )|eq( true() ) )}
{attribute_view_gui attribute=$object.data_map.image href=$object.main_node.url_alias|ezurl image_class=$size align=$align}
{elseif and( is_set( $align )|eq( false() ), is_set( $size )|eq( true() ) )}
{attribute_view_gui attribute=$object.data_map.image href=$object.main_node.url_alias|ezurl image_class=$size}
{elseif and( is_set( $align )|eq( true() ), is_set( $size )|eq( false ) )}
{attribute_view_gui attribute=$object.data_map.image href=$object.main_node.url_alias|ezurl align=$align}
{else}
{attribute_view_gui attribute=$object.data_map.image href=$object.main_node.url_alias|ezurl}
{/if}