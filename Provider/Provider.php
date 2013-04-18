<?php

namespace Quality\Bundle\CurrencyConverterBundle\Provider;

/**
 * Provider
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013
 */
abstract class Provider implements ProviderInterface
{
    
    public abstract function convert($from, $to, $amount = 1.0);
    
    public abstract function getName();
    
}