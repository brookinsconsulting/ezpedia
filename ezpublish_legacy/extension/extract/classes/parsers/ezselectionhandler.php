<?php
class eZSelectionHandler extends BaseHandler
{
    function exportAttribute( &$attribute )
    {
        $content = $attribute->content();
        $content = ( is_array( $content ) and count( $content ) == 1 ) ? $attribute->metaData() : $attribute->isA();
        return $this->escape( $content );
    }
}
?>