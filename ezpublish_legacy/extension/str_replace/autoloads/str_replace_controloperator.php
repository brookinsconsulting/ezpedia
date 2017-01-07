<?php

class MyStrReplaceOperator
{
    /*!
     Constructor
    */
    function MyStrReplaceOperator()
    {
        $this->Operators = array( 'ezstr_replace');
    }

    /*!
     Returns the operators in this class.
    */
    function operatorList()
    {
        return $this->Operators;
    }

    /*!
     \return true to tell the template engine that the parameter list
    exists per operator type, this is needed for operator classes
    that have multiple operators.
    */
    function namedParameterPerOperator()
    {
        return true;
    }

    /*!
     The first operator has two parameters, the other has none.
     See eZTemplateOperator::namedParameterList()
    */
    function namedParameterList()
    {
        return array(
                      'ezstr_replace' => array('search' => array( 'type' => 'string',
                                                                     'required' => true,
                                                                     'default' => '' ),
                                                'replace' => array( 'type' => 'string',
                                                                     'required' => true,
                                                                     'default' => '' ),
                                                'subject' => array( 'type' => 'string',
                                                                     'required' => true,
                                                                     'default' => '' )
                                            ) );
    }

    /*!
     Executes the needed operator(s).
     Checks operator names, and calls the appropriate functions.
    */
    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters )
    {
        switch ( $operatorName )
        {
            case 'ezstr_replace':
            {
                $operatorValue = str_replace( $namedParameters['search'], $namedParameters['replace'], $namedParameters['subject'] );
            } break;
        }
    }

    /// \privatesection
    var $Operators;
}

?>