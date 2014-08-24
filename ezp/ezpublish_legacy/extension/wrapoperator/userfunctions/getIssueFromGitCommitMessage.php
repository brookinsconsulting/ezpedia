<?php

    // Quick and dirty way to get the issue number from a commit message
    function getIssueFromGitCommitMessage( $data )
    {
        //given string $data, will return the first $issue string in that string
	$ret = false;
        $limit = 5;

        // test title first
	$splitTitle = preg_split( "/EZP-/", $data['title'] );

	if( isset( $splitTitle[1] ) )
          $splitTitleTestForZero = preg_split( "/0/", $splitTitle[1] );
	else
          $splitTitleTestForZero = null;

	if( $splitTitleTestForZero[0] == 0 ) { $limit = 6; } else { $limit = 5; }

        // test message second
        $splitMessage = preg_split( "/EZP-/", $data['content'] );

        // eZDebug::writeDebug( "wrap_operator: getIssueFromPubSVNCommitMessage, results: " . print_r( $splitMessage, TRUE) );

	if( isset( $splitMessage[1] ) )
          $splitMessageTestForZero = preg_split( "/0/", $splitMessage[1] );
	else
          $splitMessageTestForZero = null;

	if( $splitMessageTestForZero[0] == 0 ) { $limit = 6; } else { $limit = 5; }

	if( isset( $splitTitle[1] ) ) {
	    $match = $splitTitle[1];
            $issue = substr( $match, 0, +$limit );

	    if ( $issue != '' && count( $issue ) <= 5 && is_numeric( $issue ) ) {
               // eZDebug::writeDebug( "wrap_operator: getIssueFromPubSVNCommitMessage, results: " . print_r( $issue, TRUE) );
               $ret = $issue;
	    }
	}
	elseif( isset( $splitMessage[1] ) ) {
	    $match = $splitMessage[1];
    	    $issue = substr( $match, 0, +$limit );

	    if ( $issue != '' && count( $issue ) <= 5 && is_numeric( $issue ) ) {
               // eZDebug::writeDebug( "wrap_operator: getIssueFromPubSVNCommitMessage, results: " . print_r( $issue, TRUE) );
 	       $ret = $issue;
	    }
	}

        return $ret;
    }

?>