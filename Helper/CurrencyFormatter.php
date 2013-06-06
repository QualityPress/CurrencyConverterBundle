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
        if (false === is_float($amount)) {
            $p1 = strrpos($amount, '.');
            $p2 = strrpos($amount, ',');

            // Verificar se possui os dois separadores
            if (null !== $p1 && null !== $p2) {
                $amount = ($p1 > $p2) ? str_replace(',', '', $amount) : str_replace('.', '', $amount);
            }

            $amount = number_format(str_replace(',', '.', $amount), 2, '.', '');
        }

        $amount = $this->getFormatter()->formatCurrency($amount, $currency);
        return $this->convertEncoding($amount);
    }
    
    public function autoFormat($amount)
    {   
        return $this->format($amount, $this->getCurrencyByLocale());
    }
    
    public function parseSymbolByAmount($amount, $currency = null)
    {
        $amount = trim(str_replace($this->parseAmount($amount, $currency), '', $amount));        
        return $this->convertEncoding($amount);
    }
    
    public function parseSymbolByLocale($culture = null)
    {
        $culture = ($culture === null) ? $this->container->get('request')->getLocale() : $culture;
        return $this->getFormatter($culture)->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);
    }
    
    public function parseAmount($amount, $currency = null)
    {
        $currency = (null === $currency) ? $this->getCurrencyByLocale() : $currency;
        $amount = $this->getFormatter()->parseCurrency($amount, $currency);
        
        return number_format($amount, 2, $this->getFormatter()->getSymbol(\NumberFormatter::DECIMAL_SEPARATOR_SYMBOL), $this->getFormatter()->getSymbol(\NumberFormatter::GROUPING_SEPARATOR_SYMBOL));
    }
    
    public function getCurrencyByLocale($locale = null, $byConfig = true)
    {
        $currency = $this->defaultCurrency;
        $locale = ($locale === null) ? $this->container->get('request')->getLocale() : $locale;
        
        if (true === $byConfig) {
            foreach ($this->transformers as $conversion) {
                if ($locale == $conversion['locale']) {
                    $currency = $conversion['currency'];
                }
            }
        } else {
            $formatter = $this->getFormatter($locale);
            if ('' !== $item = $formatter->getTextAttribute(\NumberFormatter::CURRENCY_CODE))
                $currency = $item;
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
    protected function getFormatter($culture = null, $style = \NumberFormatter::CURRENCY)
    {
        $culture = ($culture === null) ? $this->container->get('request')->getLocale() : $culture;
        $formatter = new \NumberFormatter($culture, $style);
        return $formatter;
    }
    
}