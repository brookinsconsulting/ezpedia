<?php
/**
 * @package ezpedia
 * @class   ezpediaSocialNetworksPublishHandlerTwitter
 */

class ezpediaSocialNetworksPublishHandlerTwitter extends nxcSocialNetworksPublishHandler
{
	protected $name = 'Twitter';

        public $urlShortenService = 'IsGd';
        public $shortenUrl = true;

        public function shortenUrl( $url )
        {
                $ch = curl_init();
                curl_setopt( $ch, CURLOPT_URL, $url );
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
                curl_setopt( $ch, CURLOPT_HEADER, 0 );
                $shortUrl = curl_exec( $ch );
                curl_close( $ch );

                return $shortUrl;
        }

        public function shortenUrlToLy( $url )
        {
                $call = "http://to.ly/api.php?longurl=" . urlencode( $url );
                
                return $this->shortenUrl( $call );
        }

        public function shortenUrlIsGd( $url )
        {
                $call = "http://is.gd/create.php?format=simple&url=" . urlencode( $url );
                
                return $this->shortenUrl( $call );
        }

        public function shortenUrlVGD( $url )
        {
                $call = "http://v.gd/create.php?format=simple&url=" . urlencode( $url );
                
                return $this->shortenUrl( $call );
        }

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

                        if( $this->shortenUrl && $this->urlShortenService == 'IsGd' )
                        {
                           $url = $this->shortenUrlIsGd( $url );
                        }
                        elseif( $this->shortenUrl && $this->urlShortenService == 'VGD' )
                        {
                           $url = $this->shortenUrlVGD( $url );
                        }
                        elseif( $this->shortenUrl && $this->urlShortenService == 'ToLy' )
                        {
                           $url = $this->shortenUrlToLy( $url );
                        }

			$messageLength = $messageLength - strlen( $url ) - strlen( $messageIntro ) - strlen( $messageEnd ) - strlen( $messageOutro ) - 1;
		}

		$messageBody = mb_substr( $messageBody, 0, $messageLength );

                $message = $messageIntro . $messageBody . $messageEnd;

		if( $url ) {
			$message .= ' ' . $url;
		}

                $message .= $messageOutro;

                print_r( 'Len: ' . strlen( $message ) ); echo "<hr />";

                print_r( $message ); echo "<hr />";

		$response = $this->getAPI()->post(
			'statuses/update',
			array( 'status' => $message )
		);

                print_r( $response ); die();

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
