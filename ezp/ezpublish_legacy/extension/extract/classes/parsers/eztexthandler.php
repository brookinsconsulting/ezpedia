<?php

class eZTextHandler extends BaseHandler
{
    public function exportAttribute( &$attribute )
    {
        $content = $attribute->content();
        return $this->escape( $content );
    }
}
?>
