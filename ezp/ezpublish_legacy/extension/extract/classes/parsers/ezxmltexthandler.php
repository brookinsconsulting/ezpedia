<?php
class eZXMLTextHandler extends BaseHandler
{
	public function exportAttribute( &$attribute )
	{
		$content = $attribute->content();
		return $this->escape( $content->XMLData );
	}
}
?>
