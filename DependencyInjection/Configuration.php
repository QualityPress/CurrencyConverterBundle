<?php

namespace Quality\Bundle\CurrencyConverterBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('quality_currency_converter');

        $rootNode
            ->children()
                
                // Conexão e ttl
                ->scalarNode('connection')->isRequired()->end()
                ->scalarNode('time_to_live')->defaultValue(3600)->end()
        
                // Classes
                ->arrayNode('classes')
					->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('formatter')->defaultValue('Quality\\Bundle\\CurrencyConverterBundle\\Helper\\CurrencyFormatter')->end()
                        ->scalarNode('conversion')->defaultValue('Quality\\Bundle\\CurrencyConverterBundle\\Entity\\Conversion')->end()
                        ->scalarNode('manager')->defaultValue('Quality\\Bundle\\CurrencyConverterBundle\\Manager\\ConversionManager')->end()
                        ->scalarNode('provider_manager')->defaultValue('Quality\\Bundle\\CurrencyConverterBundle\\Provider\Manager\\ProviderManager')->end()
                    ->end()
                ->end()
                
                // Definição dos provedores
                ->arrayNode('providers')
                    ->requiresAtLeastOneElement()
                    ->prototype('scalar')->end()
                ->end()
                
                // i18n transformadores
                ->arrayNode('intl')
                    ->children()
                        // Default
                        ->scalarNode('default_currency')->defaultValue('USD')->end()

                        // Transformadores
                        ->arrayNode('transformers')
                            ->requiresAtLeastOneElement()
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('locale')->isRequired()->end()
                                    ->scalarNode('currency')->isRequired()->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                
                // Twig
                ->arrayNode('twig_extension')
                    ->children()
                        ->scalarNode('class')->defaultValue('Quality\\Bundle\\CurrencyConverterBundle\\Twig\\Extension\\CurrencyExtension')->end()
                        ->scalarNode('default_provider')->isRequired()->end()
                    ->end()
                ->end()
                
                // Sessão
                ->arrayNode('storage')
                    ->children()
                        ->scalarNode('class')->defaultValue('Quality\\Bundle\\CurrencyConverterBundle\\Storage\\CurrencyStorage')->end()
                        ->scalarNode('session_key')->defaultValue('_qualitypress.current-currency')->end()
                    ->end()
                ->end()
                
            ->end()
        ;

        return $treeBuilder;
    }
    
}
