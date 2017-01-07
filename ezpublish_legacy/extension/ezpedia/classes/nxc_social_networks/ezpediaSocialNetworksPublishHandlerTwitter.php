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
        $messageLength = 140;

        $message = $this->message( $this, $object, $message, $messageLength, $options, $options['message_handler'] );

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
