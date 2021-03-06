<?php

namespace KnpU\OAuth2ClientBundle\Tests;

use KnpU\OAuth2ClientBundle\Exception\MissingAuthorizationCodeException;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use KnpU\OAuth2ClientBundle\Client\OAuth2Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class SocialAuthenticatorTest extends \PHPUnit_Framework_TestCase
{
    public function testFetchAccessTokenSimplyReturns()
    {
        $authenticator = new StubSocialAuthenticator();
        $client = $this->prophesize('KnpU\OAuth2ClientBundle\Client\OAuth2Client');
        $client->getAccessToken()
            ->willReturn('expected_access_token');

        $actualToken = $authenticator->doFetchAccessToken($client->reveal());
        $this->assertEquals('expected_access_token', $actualToken);
    }

    /**
     * @expectedException \KnpU\OAuth2ClientBundle\Security\Exception\NoAuthCodeAuthenticationException
     */
    public function testFetchAccessTokenThrowsAuthenticationException()
    {
        $authenticator = new StubSocialAuthenticator();
        $client = $this->prophesize('KnpU\OAuth2ClientBundle\Client\OAuth2Client');
        $client->getAccessToken()
            ->willThrow(new MissingAuthorizationCodeException());

        $authenticator->doFetchAccessToken($client->reveal());
    }
}

class StubSocialAuthenticator extends SocialAuthenticator
{
    public function doFetchAccessToken(OAuth2Client $client)
    {
        return $this->fetchAccessToken($client);
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
    }
    public function getCredentials(Request $request)
    {
    }
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
    }
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
    }
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
    }
}