<?php
/**
 * @package eZpedia
 * @class   ezpediaSocialNetworksMessageHandlerDefault
 **/

class ezpediaSocialNetworksMessageHandlerDefault extends nxcSocialNetworksMessageHandler
{
    public $name = 'eZpedia';

    public static function message( $publishHandler, eZContentObject $object, $message, $messageLength = null, $options ) {
        $url = false;

        $messageLength = 139;

        if( $object->attribute( 'class_identifier' ) == 'article'
            || $object->attribute( 'class_identifier' ) == 'wiki_article' )
        {
            $contentType = 'article';
        }
        elseif( $object->attribute( 'class_identifier' ) == 'wiki_namespace' )
        {
            $contentType = 'namespace';
        }
        elseif( $object->attribute( 'class_identifier' ) == 'forum_reply'
                ||  $object->attribute( 'class_identifier' ) == 'forum_topic'
                ||  $object->attribute( 'class_identifier' ) == 'forum' )
        {
            $contentType = 'forum post';
        }
        else
        {
            $contentType = 'article';
        }

        $messageIntro = 'The ' . $contentType . ' "';
        $messageBody = $message;
        $messageEnd = ( $object->attribute( 'current_version' ) == 1 ) ? '" was published.' : '" was updated.';
        $messageOutro = " #ezpublish";

        if(
            isset( $options['include_url'] )
            && (bool) $options['include_url'] === true
        ) {
            $url = $object->attribute( 'main_node' )->attribute( 'url_alias' );
            eZURI::transformURI( $url, true, 'full' );

            if(
                isset( $options['shorten_url'] )
                && (bool) $options['shorten_url'] === true
            ) {
                $urlReturned = $publishHandler->shorten( $url, $options['shorten_handler'] );
                if( is_string( $urlReturned ) ) {
                    $url = $urlReturned;
                }
            }

            if( $messageLength != null ) {
                $messageLength = $messageLength - strlen($url) - strlen($messageIntro) - strlen($messageEnd) - strlen($messageOutro) - 1;
            }
        }

        if( $messageLength != null ) {
            $messageBody = mb_substr( $messageBody, 0, $messageLength );
        }

        $message = $messageIntro . $messageBody . $messageEnd;

        if( $url ) {
            $message .= ' ' . $url;
        }

        $message .= $messageOutro;

        return $message;
    }
}
?>