<?php

class eZEmailHandler extends BaseHandler
{
	public function exportAttribute( &$attribute )
	{

		return $this->escape( $attribute->content() );
	}
}

?>