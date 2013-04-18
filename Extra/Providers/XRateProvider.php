<?php

namespace Quality\Bundle\CurrencyConverterBundle\Extra\Providers;

use Quality\Bundle\CurrencyConverterBundle\Provider\GatewayProvider;
use Quality\Bundle\CurrencyConverterBundle\Http\Request;

/**
 * XRateProvider
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013
 */
class XRateProvider extends GatewayProvider
{
    
    public function convert($from, $to, $amount = 1.0)
    {
        $destiny = "http://www.x-rates.com/calculator/?from={$from}&to={$to}&amount={$amount}";
        $request = new Request($destiny, 'GET');
        
        $response = $this->bind($request);
        if (null === $content = $response->getContent()) {
            throw new \RuntimeException(sprintf(
                'Houve algum problema para localização das informações.'
            ));
        }
        
        $dom = new \DomDocument();
        @$dom->loadHTML($content);
        $xpath  = new \DOMXPath($dom);
        $value  = $xpath->query('//span[@class="ccOutputRslt"]');
        
        // Verificar se ocorre erro
        $result = preg_replace('/[^0-9.]|[0-9]*$/', '', $value->item(0)->nodeValue);
        if (0 == $result) {
            throw new \RuntimeException(sprintf(
                'The resulted amount "%s" is invalid.',
                $result
            ));
        }
        
        return $result;
    }
    
    public function getName()
    {
        return 'xrate_provider';
    }

}