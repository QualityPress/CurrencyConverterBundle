<?php

namespace Quality\Bundle\CurrencyConverterBundle\Provider;

/**
 * ProviderInterface
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013
 */
interface ProviderInterface
{
    
    /**
     * Efetuar a conversão.
     * Método no qual deverá ser realizada a conversão da moeda.
     * 
     * @param string $from
     * @param string $to
     * @param decimal $amount
     */
    function convert($from, $to, $amount = 1.0);
    
    /**
     * Localizar o nome do plugin em questão
     * 
     * @return string
     */
    function getName();
    
}