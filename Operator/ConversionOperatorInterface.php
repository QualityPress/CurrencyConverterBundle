<?php

namespace Quality\Bundle\CurrencyConverterBundle\Operator;

/**
 * ConversionOperatorInterface
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENSE
 * @copyright (c) 2013
 */
interface ConversionOperatorInterface
{
    
    /**
     * Efetua a conexão junto ao provedor e armazena as 
     * informações junto ao objeto de conversão.
     * 
     * @param string $provider
     * @param string $from
     * @param string $to
     * @param decimal $amount
     * 
     * @return \Quality\Bundle\CurrencyConverterBundle\Model\ConversionInterface
     */
    function doConversion($provider, $from, $to, $amount);
    
}