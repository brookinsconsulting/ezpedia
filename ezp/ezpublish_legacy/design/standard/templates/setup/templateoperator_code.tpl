<?php
{* DO NOT EDIT THIS FILE! Use an override template instead. *}
/*!
  \class   {$full_class_name} {$file_name}
  \ingroup eZTemplateOperators
  \brief   {$description_brief}
  \version 1.0
  \date    {currentdate()|l10n(datetime)}

{if $creator_name}
  \author  {$creator_name}
{/if}


{$description_full|indent(2)}

{if $example_code}

  {'Example'|i18n('design/standard/setup/operatorcode')}:
\code
{$example_code}
\endcode
{/if}

*/

/*
If you want to have autoloading of this operator you should create
a eztemplateautoload.php file and add the following code to it.
The autoload file must be placed somewhere specified in AutoloadPathList
under the group TemplateSettings in settings/site.ini

$eZTemplateOperatorArray = array();
$eZTemplateOperatorArray[] = array( 'script' => '{$file_name}',
                                    'class' => '{$full_class_name}',
                                    'operator_names' => array( '{$operator_name}' ) );

If your template operator is in an extension, you need to add the following settings:

To extension/YOUREXTENSION/settings/site.ini.append:
---
[TemplateSettings]
ExtensionAutoloadPath[]=YOUREXTENSION
---

To extension/YOUREXTENSION/autoloads/eztemplateautoload.php:
----
$eZTemplateOperatorArray = array();
$eZTemplateOperatorArray[] = array( 'script' => 'extension/YOUEXTENSION/YOURPATH/{$file_name}',
                                    'class' => '{$full_class_name}',
                                    'operator_names' => array( '{$operator_name}' ) );
---

Create the files if they don't exist, and replace YOUREXTENSION and YOURPATH with the correct values.

*/


class {$full_class_name}
{literal}{{/literal}
    /*!
      {'Constructor, does nothing by default.'|i18n('design/standard/setup/operatorcode')}
    */
    function __construct()
    {literal}{{/literal}
    {literal}}{/literal}

    /*!
     {'\\return an array with the template operator name.'|i18n('design/standard/setup/operatorcode')}
    */
    function operatorList()
    {literal}{{/literal}
        return array( '{$operator_name}' );
    {literal}}{/literal}


{if $single_operator|not}
    /*!
     \return true to tell the template engine that the parameter list exists per operator type,
             this is needed for operator classes that have multiple operators.
    */
    function namedParameterPerOperator()
    {literal}{{/literal}
        return true;
    {literal}}{/literal}


{/if}

{if $parameter_check|eq(2)}
    /*!
     See eZTemplateOperator::namedParameterList
    */
    function namedParameterList()
    {literal}{{/literal}
        return array( '{$operator_name}' => array( 'first_param' => array( 'type' => 'string',
{set-block variable=parameter_extra}
                        'required' => false,
                        'default' => 'default text' ),
'second_param' => array( 'type' => 'integer',
                         'required' => false,
                         'default' => 0 ) ) );
{/set-block}

{$:parameter_extra|indent(sum(35,$operator_name|count))}
    {literal}}{/literal}


{/if}

    /*!
     {'Executes the PHP function for the operator cleanup and modifies \a $operatorValue.'|i18n('design/standard/setup/operatorcode')}
    */
    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters, $placement )
    {literal}{{/literal}

{if $parameter_check|eq(2)}
        $firstParam = $namedParameters['first_param'];
        $secondParam = $namedParameters['second_param'];

{/if}

{if $parameter_check|eq(3)}
        for ( $i = 0; $i < count( $operatorParameters ); ++$i )
        {literal}{{/literal}
            $operatorParameter =& $operatorParameters[$i];
            // Fetch the value of the parameter structure
            $operatorParameterValue = $tpl->elementValue( $operatorParameter, $rootNamespace, $currentNamespace );
        {literal}}{/literal}

{/if}

{if $single_operator}
        // {'Example code. This code must be modified to do what the operator should do. Currently it only trims text.'|i18n('design/standard/setup/operatorcode')}
        {if $use_output}$operatorValue = {/if}trim({if $use_input} $operatorValue {/if});
{else}
        // {'Example code. This code must be modified to do what the operator should do. Currently it only trims text.'|i18n('design/standard/setup/operatorcode')}
        switch ( $operatorName )
        {literal}{{/literal}
            case '{$operator_name}':
            {literal}{{/literal}
                {if $use_output}$operatorValue = {/if}trim({if $use_input} $operatorValue {/if});
            {literal}}{/literal} break;
        {literal}}{/literal}
{/if}

    {literal}}{/literal}
{literal}}{/literal}

?>