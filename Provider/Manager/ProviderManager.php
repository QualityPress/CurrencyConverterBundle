<?php

namespace Quality\Bundle\CurrencyConverterBundle\Provider\Manager;

/**
 * ProviderManager
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013
 */
class ProviderManager implements ProviderManagerInterface
{
    
    protected $providers;
    
    public function count()
    {
        return count($this->providers, COUNT_NORMAL);
    }

    public function add(\Quality\Bundle\CurrencyConverterBundle\Provider\ProviderInterface $provider)
    {
        $this->providers[$provider->getName()] = $provider;
    }

    public function all()
    {
        return $this->providers;
    }

    public function get($name)
    {
        return (true === $this->has($name)) ? $this->providers[$name] : null;
    }

    public function has($name)
    {
        return array_key_exists($name, $this->providers);
    }
    
}