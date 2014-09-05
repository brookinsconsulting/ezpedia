<?php
/**
 * @package ezpedia
 * @class   ezpediaSocialNetworksPublishHandlerTwitter
 */

class ezpediaSocialNetworksPublishHandlerTwitter extends nxcSocialNetworksPublishHandler
{
    protected $name = 'Twitter';

    public function publish( eZContentObject $object, $message ) {
        $options = $this->getOptions();

        $messageIntro = 'The article "';
        $messageBody = $message;
        $messageEnd = ( $object->attribute( 'current_version' ) == 1 ) ? '" was published.' : '" was updated.';
        $messageOutro = " #ezpublish";

        $messageLength = 140;
        $url = false;
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
                $urlReturned = $this->shorten( $url );
                if( is_string( $urlReturned ) ) {
                    $url = $urlReturned;
                }
            }

            $messageLength = $messageLength - strlen( $url ) - strlen( $messageIntro ) - strlen( $messageEnd ) - strlen( $messageOutro ) - 1;
        }

        $messageBody = mb_substr( $messageBody, 0, $messageLength );

        $message = $messageIntro . $messageBody . $messageEnd;

        if( $url ) {
            $message .= ' ' . $url;
        }

        $message .= $messageOutro;

        //print_r( 'Len: ' . strlen( $message ) ); echo "<hr />";

        //print_r( $message ); echo "<hr />";

        $response = $this->getAPI()->post(
            'statuses/update',
            array( 'status' => $message )
        );

        //print_r( $response ); die();

        if( isset( $response->error ) ) {
            throw new Exception( $response->error );
        }
    }

    protected function getAPI() {
        $OAuth2      = nxcSocialNetworksOAuth2::getInstanceByType( 'twitter' );
        $OAuth2Token = $OAuth2->getToken();

        return new TwitterOAuth(
            $OAuth2->appSettings['key'],
            $OAuth2->appSettings['secret'],
            $OAuth2Token->attribute( 'token' ),
            $OAuth2Token->attribute( 'secret' )
        );
    }
}
?>
