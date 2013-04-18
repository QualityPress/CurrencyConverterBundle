<?php

namespace Quality\Bundle\CurrencyConverterBundle\Extra\Providers;

use Quality\Bundle\CurrencyConverterBundle\Exception\InvalidFormatException;
use Quality\Bundle\CurrencyConverterBundle\Provider\GatewayProvider;
use Quality\Bundle\CurrencyConverterBundle\Http\Request;

/**
 * YahooProvider
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENSE
 * @copyright (c) 2013
 */
class YahooProvider extends GatewayProvider
{
    
    public function convert($from, $to, $amount = 1.0)
    {
        // Definido diretamente devido ao estranho formato
        $destiny = "http://finance.yahoo.com/d/quotes.csv?s={$from}{$to}=X&f=l1";
        $request = new Request($destiny, 'GET');
        
        $response = $this->bind($request, false, true);
        if ('Missing Format Variable.' === $valor = $response->getContent()) {
            throw new InvalidFormatException(sprintf(
                'Algum dos formatos fornecidos ("%s", "%s") para conversão não é válido.',
                $from,
                $to
            ));
        }
        
        if (0 == $valor) {
            throw new \RuntimeException(sprintf(
                'The resulted amount "%s" is invalid.',
                $valor
            ));
        }
        
        // Como a conversão sempre será do montante 1, multiplico pelo amount
        return $valor * $amount;
    }
    
    public function getName()
    {
        return 'yahoo_provider';
    }

}