<?php
class ezBinaryfileExportHandler extends BaseHandler
{
       function exportAttribute( &$attribute )
       {
			$content = $attribute->content();
		    			
			if ($content)
			{
		    	$filePath = $content->filePath();
		    	return $filePath;   	
			}

		    return;   	
       }
}
?>