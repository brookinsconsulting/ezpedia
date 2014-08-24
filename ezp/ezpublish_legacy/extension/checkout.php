<?php

$csv = fopen( 'extensions.csv', 'r' );

while( ( $data = fgetcsv( $csv, null, ';' ) ) !== false )
{
    echo $data[0] . PHP_EOL;
    if ( !file_exists( $data[0] ) )
    {
        exec( 'svn checkout ' . escapeshellarg( $data[1] ) . ' ' . escapeshellarg( $data[0] ) );
    }
}
?>