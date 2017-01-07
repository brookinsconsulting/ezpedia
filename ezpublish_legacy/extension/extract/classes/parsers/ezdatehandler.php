<?php
class eZDateHandler extends BaseHandler
{
    public function exportAttribute( &$attribute )
    {
        return $this->escape( strftime( '%Y-%m-%d', $attribute->metaData() ) );
    }
}
?>