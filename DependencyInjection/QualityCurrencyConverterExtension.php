<?php

namespace Quality\Bundle\CurrencyConverterBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

use Symfony\Component\DependencyInjection\Definition;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class QualityCurrencyConverterExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        
        // Definir conexão
        $connection = $config['connection'];
        $container->getDefinition('currency_converter.entity_manager')->setArguments(array($connection));
        
        // Definição de alguns parâmetros
        $classes = $config['classes'];
        $container->setParameter('quality_currency_converter.formatter.class', $classes['formatter']);
        $container->setParameter('quality_currency_converter.manager.class', $classes['manager']);
        $container->setParameter('quality_currency_converter.conversion.class', $classes['conversion']);
        $container->setParameter('quality_currency_converter.provider_manager.class', $classes['provider_manager']);
        $container->setParameter('quality_currency_converter.provider_manager.class', $classes['provider_manager']);
        $container->setParameter('quality_currency_converter.time_to_live', $config['time_to_live']);
        
        // I18N
        $container->setParameter('quality_currency_converter.parameter.default_currency', $config['intl']['default_currency']);
        $container->setParameter('quality_currency_converter.parameter.transformers', $config['intl']['transformers']);
        
        // Twig extension
        $container->setParameter('quality_currency_converter.twig_extension.class', $config['twig_extension']['class']);
        
        // Storage
        $container->setParameter('quality_currency_converter.storage.class', $config['storage']['class']);
        $container->setParameter('quality_currency_converter.parameter.storage_key', $config['storage']['session_key']);
        
        // Definir provedores
        $container->setParameter('quality_currency_converter.default_provider', $config['default_provider']);
        $this->compilerProviders($container, $config['providers']);
    }
    
    protected function compilerProviders(ContainerBuilder $container, $providers)
    {
        $definition = $container->getDefinition('currency_converter.manager.provider');
        foreach ($providers as $providerClass) {
            $providerDefinition = new Definition($providerClass);
            $providerDefinition->setPublic(false);
            
            $definition->addMethodCall('add', array($providerDefinition));
        }
    }
    
}
