<?php
class eZEnumHandler extends BaseHandler
{
   public function exportAttribute( &$attribute )
   {
        return $this->escape( $attribute->metaData() );
   }
}
?>