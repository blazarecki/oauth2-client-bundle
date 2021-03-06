<?php

namespace KnpU\OAuth2ClientBundle\DependencyInjection\Providers;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;

class GenericProviderConfigurator implements ProviderConfiguratorInterface
{
    public function buildConfiguration(NodeBuilder $node)
    {
        $node
            ->scalarNode('provider_class')
                ->info('The class name of your provider class (e.g. the one that extends AbstractProvider)')
                ->isRequired()
            ->end()
            ->scalarNode('client_class')
                ->info('If you have a sub-class of OAuth2Client you want to use, add it here')
                ->defaultValue('KnpU\OAuth2ClientBundle\Client\OAuth2Client')
            ->end()
            ->arrayNode('provider_options')
                ->info('Other options to pass to your provider\'s constructor')
                ->prototype('variable')->end()
            ->end()
        ;
    }

    public function getProviderClass(array $config)
    {
        return $config['provider_class'];
    }

    public function getProviderOptions(array $config)
    {
        return array_merge(array(
            'clientId' => $config['client_id'],
            'clientSecret' => $config['client_secret'],
        ), $config['provider_options']);
    }

    public function getPackagistName()
    {
        return false;
    }

    public function getLibraryHomepage()
    {
        return false;
    }

    public function getProviderDisplayName()
    {
        return 'Generic';
    }

    public function getClientClass(array $config)
    {
        return $config['client_class'];
    }
}