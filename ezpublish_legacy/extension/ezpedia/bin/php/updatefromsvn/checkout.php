<?php

$csv = fopen( 'extension/ezpedia/bin/php/updatefromsvn/extensions.csv', 'r' );

while( ( $data = fgetcsv( $csv, null, ';' ) ) !== false )
{
    echo $data[0] . PHP_EOL;
    if ( !file_exists( $data[0] ) )
    {
        // exec( 'cd extension' );

        exec( 'cd extension; svn checkout ' . escapeshellarg( $data[1] ) . ' ' . escapeshellarg( $data[0] ) );
    }
}

?>