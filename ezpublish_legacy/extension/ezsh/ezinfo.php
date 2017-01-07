<?php

class ezshInfo
{
    static function info()
    {
        return array( 'Name' => "eZ Geshi (a.k.a. eZSH, a.k.a. eZ Syntax Highlighter)",
                      'Version' => "1.4.1-dev",
                      'Copyright' => "Copyright (C) 2005-2012 Lukasz Serwatka",
                      'License' => "GNU General Public License v2.0",
                      'Includes the following third-party software' => array( 'Name' => 'GeSHi - Generic Syntax Highlighter',
                                                                              'Version' => '1.0.8.10',
                                                                              'License' => 'GNU General Public License v2.0',
                                                                              'For more information' => 'http://qbnz.com/highlighter/' )
                      );
    }
}

?>
