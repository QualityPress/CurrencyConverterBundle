<?php

namespace Quality\Bundle\CurrencyConverterBundle\Extra\Providers;

use Quality\Bundle\CurrencyConverterBundle\Provider\GatewayProvider;
use Quality\Bundle\CurrencyConverterBundle\Http\Request;

/**
 * GoogleProvider
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013
 */
class GoogleProvider extends GatewayProvider
{
    
    public function convert($from, $to, $amount = 1.0)
    {
        // Definido diretamente devido ao estranho formato
        $destiny = "http://www.google.com/ig/calculator?hl=en&q={$amount}{$from}=?{$to}";
        $request = new Request($destiny, 'GET');
        
        $response = $this->bind($request);
        
        // Tratamento de dados
        $content    = str_replace(array('lhs', 'rhs', 'error', 'icc'), array('"lhs"', '"rhs"', '"error"', '"icc"'), $response->getContent());
        $object     = json_decode($content);
        
        $value = preg_replace('/[^0-9.]|[0-9]*$/', '', $object->rhs);
        if ('' === $value) {
            throw new \RuntimeException(sprintf(
                'The resulted amount "%s" is invalid.',
                $value
            ));
        }
        
        return number_format(floatval($value), 5, '.', '');
    }
    
    public function getName()
    {
        return 'google_provider';
    }

}