<?php
/**
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2013.4
 * @package lib
 */

// Operator autoloading

$eZTemplateOperatorArray = array();

$eZTemplateOperatorArray[] = array( 'class' => 'eZPDF',
                                    'operator_names' => array( 'pdf' ) );

?>
