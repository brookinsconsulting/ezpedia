<?php
class eZBooleanHandler extends BaseHandler
{
    public function exportAttribute( &$attribute )
    {
        if ( $attribute->content() )
            return $this->escape( '1' );
        else
            return $this->escape( '0' );
    }
}
?>
