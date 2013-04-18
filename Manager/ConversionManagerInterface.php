<?php

namespace Quality\Bundle\CurrencyConverterBundle\Manager;

/**
 * ConversionManagerInterface
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENSE
 * @copyright (c) 2013
 */
interface ConversionManagerInterface
{
 
    /**
     * Efetuar a consulta junto ao provedor.
     * Ao finalizar a consulta tentará armazenas as informações
     * junto ao banco de dados.
     * 
     * @param string $from      Moeda de origem
     * @param string $to        Moeda de destino
     * @param decimal $amount   Valor a ser convertido
     * $param string $provider  Nome do provedor
     * 
     * @return \Quality\Bundle\CurrencyConverterBundle\Model\ConversionInterface
     */
    function convert($from, $to, $amount, $provider);
    
}