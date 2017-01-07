<?php

class eZIdentifierHandler extends BaseHandler
{
    function exportAttribute( &$attribute )
    {
        return $this->escape( $attribute->content() );
    }
}

?>