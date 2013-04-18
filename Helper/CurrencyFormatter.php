<?php

namespace Quality\Bundle\CurrencyConverterBundle\Helper;

use Quality\Bundle\CurrencyConverterBundle\Exception\ExtensionNotLoadedException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * CurrencyFormatter
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENSE
 * @copyright (c) 2013
 */
class CurrencyFormatter implements CurrencyFormatterInterface
{
    
    protected $container;
    protected $defaultCurrency;
    protected $transformers;
    
    public function __construct(ContainerInterface $container, $defaultCurrency, $transformers)
    {
        if (false === extension_loaded('mbstring')) {
            throw new ExtensionNotLoadedException('The mbstring extension must be loaded to use CurrencyConverter');
        }
        
        $this->container = $container;
        $this->defaultCurrency = $defaultCurrency;
        $this->transformers = $transformers;
    }
    
    public function format($amount, $currency)
    {
        $amount = $this->getFormatter()->formatCurrency($amount, $currency);
        return $this->convertEncoding($amount);
    }
    
    public function autoFormat($amount)
    {   
        return $this->format($amount, $this->getCurrencyByLocale());
    }
    
    public function parseSymbol($amount, $currency = null)
    {
        $symbol = trim(str_replace($this->parseAmount($amount, $currency), '', $amount));
        return $this->convertEncoding($symbol);
    }
    
    public function parseAmount($amount, $currency = null)
    {
        $currency = (null === $currency) ? $this->getCurrencyByLocale() : $currency;
        return $this->getFormatter()->parseCurrency($amount, $currency);
    }
    
    public function getCurrencyByLocale($locale = null)
    {
        $currency = $this->defaultCurrency;
        $locale = ($locale !== null) ? $this->container->get('request')->getLocale() : $locale;
        foreach ($this->transformers as $conversion) {
            if ($locale == $conversion['locale']) {
                $currency = $conversion['currency'];
            }
        }
        
        return $currency;
    }
    
    public function isCurrencyValid($currency)
    {
        $isValid = false;
        foreach ($this->transformers as $conversion) {
            if (strtoupper($currency) === strtoupper($conversion['currency'])) {
                $isValid = true;
            }
        }
        
        return $isValid;
    }
    
    /**
     * Efetua a conversão do encode de um string.
     * 
     * @param string $string
     * @param string $encode
     * @return string
     */
    protected function convertEncoding($string, $encode = 'UTF-8')
    {
        $encodeDetected = mb_detect_encoding($string);
        if ($encodeDetected !== $encode) {
            $string = mb_convert_encoding($string, $encodeDetected, $encode);
        }
        
        return $string;
    }
    
    /**
     * Localizará o NumberFormatter de acordo com cultura e estilo de conversão
     * 
     * @param $culture
     * @param $style
     * @return \NumberFormatter
     */
    protected function getFormatter($culture = 'en', $style = \NumberFormatter::CURRENCY)
    {
        $formatter = new \NumberFormatter($culture, $style);
        return $formatter;
    }
    
}