<?php

// Operator autoloading

$eZTemplateOperatorArray = array();

$eZTemplateOperatorArray[] =
  array( 'script' => 'extension/str_replace/autoloads/str_replace_controloperator.php',
         'class' => 'MyStrReplaceOperator',
         'operator_names' => array( 'ezstr_replace' ) );

?>