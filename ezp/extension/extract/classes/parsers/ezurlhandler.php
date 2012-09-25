<?php

class eZURLHandler extends BaseHandler
{
	public function exportAttribute( &$attribute )
	{
		$tempstring = $attribute->content() . ' ' . $attribute->DataText;
		return $this->escape( $tempstring );
	}
}

?>