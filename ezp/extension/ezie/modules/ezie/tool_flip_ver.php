<?php
/**
 * File containing the ezie horizontal flip handler
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version 5.1.0-rc1
 * @package ezie
 */
$prepare_action = new eZIEImagePreAction();

$imageconverter = new eZIEezcImageConverter( eZIEImageToolFlipVertically::filter() );

$imageconverter->perform(
    $prepare_action->getImagePath(),
    $prepare_action->getNewImagePath()
);

eZIEImageToolResize::doThumb(
    $prepare_action->getNewImagePath(),
    $prepare_action->getNewThumbnailPath()
);

echo (string)$prepare_action;
eZExecution::cleanExit();
?>
