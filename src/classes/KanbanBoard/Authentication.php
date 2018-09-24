<?php

namespace KanbanBoard;

use KanbanBoard\Config\OAuthInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class Authentication
{

    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    private $session;

    /**
     * @TODO Refactor
     *
     * @param \KanbanBoard\Config\OAuthInterface $config
     *
     * @throws \Exception
     */
    public function __construct(OAuthInterface $config)
    {
        $session = new Session();
        $session->start();
        $this->session = $session;
        $request = Request::createFromGlobals();

        $token = $session->get('gh_token');

        if ($token) {
            return;
        }

        $provider = new \League\OAuth2\Client\Provider\Github([
            'clientId'          => $config->getClientId(),
            'clientSecret'      => $config->getClientSecret(),
            'redirectUri'       => $config->getRedirectUrl(),
        ]);

        if (!$request->get('code')) {
            // @TODO Authorization URL options should be also configurable.
            $authUrl = $provider->getAuthorizationUrl(
                [
                    'state' => 'LKHYgbn776tgubkjhk',
                    'scope' => ['repo'],
                ]
            );
            $session->set('oauth2state', $provider->getState());
            $session->save();
            $redirect = new RedirectResponse($authUrl);
            $redirect->send();

            // Check given state against previously stored one to mitigate CSRF attack
        } elseif (!$request->get('state')
          || ($request->get('state') != $session->get('oauth2state'))) {
            $session->set('oauth2state', null);
            throw new \Exception('OAUTH: invalid state');

        } elseif (!$session->get('gh-token')) {
            // Try to get an access token (using the authorization code grant)
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $request->get('code'),
            ]);
            $session->set('gh-token', $token);
        }

        $session->save();
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->session->get('gh-token');
    }
}
