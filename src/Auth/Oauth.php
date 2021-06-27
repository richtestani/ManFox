<?php

namespace RichTestani\ManFox\Auth;
use League\OAuth2\Client\Provider\GenericProvider;

class OAuth {

    protected $redirect_uri = null;

    protected $provider = null;

    protected $state = null;

    protected $auth_uri = 'https://my.foxycart.com/authorize';

    protected $client_id = null;

    protected $client_secret = null;

    public function __construct($credentials, $session = null)
    {

        $this->setClientId( $credentials['client_id'] );
        $this->setClientSecret( $credentials['client_secret'] );
        $this->setRedirectURI( $credentials['redirect_uri'] );

    }

    public function setClientId($client)
    {
        $this->client_id = $client;
    }

    public function setClientSecret($secret)
    {
        $this->client_secret = $secret;
    }

    public function setRedirectURI($redirect_uri)
    {
        $this->redirect_uri = $redirect_uri;
    }

    public function auth()
    {
        header("Location:".$this->auth_uri);
    }

    public function provider()
    {

        $this->buildAuthUrl();
        
        $this->provider = new GenericProvider([
            'clientId'                => $this->client_id,    // The client ID assigned to you by the provider
            'clientSecret'            => $this->client_secret,   // The client password assigned to you by the provider
            'redirectUri'             => $this->redirect_uri,
            'urlAuthorize'            => $this->auth_uri,
            'urlAccessToken'          => 'https://api.foxycart.com/token',
            'urlResourceOwnerDetails' => 'https://api.foxycart.com',
            'scope'                   => 'store_full_access',
        ]);

        return $this;

    }

    public function refreshToken()
    {   

        $this->provider();
        
        $newAccessToken = $this->provider->getAccessToken('refresh_token', [

                'refresh_token' => getenv('FOXYCART_REFRESH_TOKEN')
        ]);

        AccessToken::put($newAccessToken->getToken());

        return $newAccessToken;
    
    }


    //authorize a store
    //get a new access token, scope and refresh token
    public function authorize()
    {

        $this->provider();

        $accessToken = $this->provider->getAccessToken('authorization_code', [
            'code' => $_GET['code'],
            'headers' => [
                'FOXY-API-VERSION' => 1
            ]
        ]);
        
        $resourceOwner = $this->provider->getResourceOwner($accessToken);
        AccessToken::put($accessToken->getToken());

        return [
            'refresh_token' => $accessToken->getRefreshToken(),
            'scope' => $accessToken->getValues()
        ];

    }

    public function hasCode()
    {
        return (isset($_GET['code'])) ? true : false;
    }

    private function setState()
    {
         $this->state = 'manfox_'.strtotime('now');
    }

    private function setRedirectUri()
    {
        if(is_null($this->redirect_uri)) {

            $this->redirect_uri = $_SERVER['SERVER_NAME'] . '/oath';

        }
        
    }

    private function buildAuthUrl()
    {   
        $this->setState();
        $this->setRedirectUri();
        $url = $this->auth_uri;
        $params = [
            'state' => $this->state,
            'client_id' => $this->client_id,
            'scope' => 'store_full_access',
            //'redirect_uri' => $this->redirect_uri,
            'response_type' => 'code'
        ];
        
        $_SESSION['manfox_auth_state'] = $this->state;

        $html_params = http_build_query($params);

        $this->auth_uri .= '?' . $html_params;

    }

}