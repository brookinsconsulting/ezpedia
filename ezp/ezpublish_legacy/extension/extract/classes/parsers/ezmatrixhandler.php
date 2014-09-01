<?php

class ezMatrixExportHandler extends BaseHandler
{
    function exportAttribute(&$attribute)
    {
        $content = $attribute->content();
        $rows = $content->attribute( 'rows' );
        foreach( $rows['sequential'] as $row )
        {

        	$matrixArray[] = eZStringUtils::implodeStr( $row['columns'], '|' );
        	
        }
        $string = eZStringUtils::implodeStr( $matrixArray, '&' );

        return $string;
    }
}
?>