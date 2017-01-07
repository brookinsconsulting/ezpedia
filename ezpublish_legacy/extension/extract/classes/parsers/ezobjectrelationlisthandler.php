<?php

class eZObjectRelationListHandler extends BaseHandler
{
	public function exportAttribute( &$attribute )
	{
		$xmlText = $attribute->attribute( 'data_text' );
        if ( trim( $xmlText ) == '' )
        {
            return "";
        }
        $doc = eZObjectRelationListType::parseXML( $xmlText );
        $content = eZObjectRelationListType::createObjectContentStructure( $doc );
			
		foreach ($content["relation_list"] as $id)
        {
        	$object=eZContentObject::fetch($id["contentobject_id"]);
            if (is_object($object))
            {
            	$names[]=$object->name();
            }
        }
        return $this->escape( join(", ", $names) );
	}
}
?>