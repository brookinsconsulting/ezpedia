<?php
/**
 * File containing the eZRSSFunctionCollection class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.07.0
 * @package kernel
 */

class eZRSSFunctionCollection
{
    function fetchList()
    {
        $result = array( 'result' => eZRSSExport::fetchList() );
        return $result;
    }

    function fetchSubtreeList( $nodeID, $maxDepth = false )
    {
        $node = eZContentObjectTreeNode::fetch( $nodeID );
        $pathString = $node->attribute( 'path_string' );

        $subQuery = "SELECT i.rssexport_id FROM ezrss_export_item i, ezcontentobject_tree n
                    WHERE
                        i.rssexport_id=e.id AND
                        i.source_node_id=n.node_id AND
                        n.path_string LIKE '$pathString%'";

        if ( is_numeric( $maxDepth ) )
        {
            $nodeDepth = $node->attribute( 'depth' );
            $maxQueryDepth = $nodeDepth + $maxDepth;
        }

        $subQuery .= " AND n.depth <= $maxQueryDepth";

        $query = "SELECT * FROM ezrss_export e
                WHERE EXISTS( $subQuery ) ORDER BY title";

        $db = eZDB::instance();
        $result = $db->arrayQuery( $query );

        $rssExports = array();
        foreach ( $result as $row )
        {
            $rssExports[] = new eZRSSExport( $row );
        }

        return array( 'result' => $rssExports );
    }

    /**
     * Checks if there is a valid RSS/ATOM Feed export for a node or not.
     *
     * @param int $nodeID
     * @return bool Return value is inside a array with return value on result, as this is used as template fetch function.
     */
    static function hasExportByNode( $nodeID )
    {
        if ( !$nodeID )
            return array( 'error' => array( 'error_type' => 'kernel',
                                            'error_code' => eZError::KERNEL_NOT_FOUND ) );

        $db = eZDB::instance();
        $res = $db->arrayQuery( "SELECT id FROM ezrss_export WHERE node_id = " . (int)$nodeID . " AND status = " . eZRSSExport::STATUS_VALID );

        return array( 'result' => isset( $res[0] ) ? true : false );
    }

    /**
     * Return valid eZRSSExport object for a specific node if it exists.
     *
     * @param int $nodeID
     * @return eZRSSExport|false Return value is inside a array with return value on result, as this is used as template fetch function.
     */
    static function exportByNode( $nodeID )
    {
        if ( !$nodeID )
            return array( 'error' => array( 'error_type' => 'kernel',
                                            'error_code' => eZError::KERNEL_NOT_FOUND ) );

        $rssExport = eZPersistentObject::fetchObject( eZRSSExport::definition(),
                                                null,
                                                array( 'node_id' => $nodeID,
                                                       'status' => eZRSSExport::STATUS_VALID ),
                                                true );

        return array( 'result' => $rssExport );
    }
}

?>
