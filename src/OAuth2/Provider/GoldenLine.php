<?php
namespace OAuth2\Provider;
use OAuth2\Provider;
use OAuth2\Token_Access;
/*
 * Uber API credentials: https://developer.uber.com/apps/
 * Uber API docs: https://developer.uber.com/
 */
/**
 * Uber OAuth Provider
 *
 * @package    laravel-oauth2
 * @category   Provider
 * @author     Andreas Creten
 */
class GoldenLine extends Provider {
    /**
     * @var  string  provider name
     */
    public $name = 'goldenline';
    /**
     * @var  string  the method to use when requesting tokens
     */
    protected $method = 'GET';
    /**
     * Returns the authorization URL for the provider.
     *
     * @return  string
     */
    public function url_authorize()
    {
        return 'https://www.goldenline.pl/oauth/v2/auth';
    }
    /**
     * Returns the access token endpoint for the provider.
     *
     * @return  string
     */
    public function url_access_token()
    {
        return 'https://www.goldenline.pl/oauth/v2/token';
    }
    public function get_user_info(Token_Access $token)
    {
        $url = 'https://api.goldenline.pl/me';

        $opts = array(
            'http' => array(
                'method'  => 'GET',
                'header'  =>
                    'Host: api.goldenline.pl'. PHP_EOL .
                    'Accept: applicaton/vnd.goldenline.v2+json'. PHP_EOL .
                    'Authorization: Bearer '.$token->access_token,
            )
        );

        $context = stream_context_create($opts);
        $user = json_decode(file_get_contents($url, false, $context));
//        dd($user->_links->cv->href);
        return array(
            'name' => $user->name,
            'surname' => $user->surname,
            'email' => $user->email,
        );
    }
}