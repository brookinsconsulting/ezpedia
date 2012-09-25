<?php
class ezMediaExportHandler extends BaseHandler
{
       function exportAttribute( &$attribute )
       {
			$content = $attribute->content();
		    			
			if ($content)
			{
		    	$info = $content->storedFileInfo();
		    	if ($info['filename'] != '')
		    	{
					$filePath = $content->filePath();
					return $filePath;   	
		    	}
			}

		    return;   	
       }
}
?>