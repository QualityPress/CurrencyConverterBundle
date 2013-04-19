<?php

namespace Quality\Bundle\CurrencyConverterBundle\Twig\Extension;

use Quality\Bundle\CurrencyConverterBundle\Helper\CurrencyFormatterInterface;
use Quality\Bundle\CurrencyConverterBundle\Manager\ConversionManagerInterface;
use Quality\Bundle\CurrencyConverterBundle\Storage\CurrencyStorage;

/**
 * CurrencyExtension
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENSE
 * @copyright (c) 2013
 */
class CurrencyExtension extends \Twig_Extension
{
    
    protected $currencyFormatter;
    protected $conversionManager;
    protected $currencyStorage;
    protected $defaultProvider;
    
    public function __construct(CurrencyFormatterInterface $currencyFormatter, ConversionManagerInterface $conversionManager, CurrencyStorage $storage, $defaultProvider)
    {        
        $this->currencyStorage = $storage;
        $this->currencyFormatter = $currencyFormatter;
        $this->conversionManager = $conversionManager;
        $this->defaultProvider = $defaultProvider;
    }
    
    public function getFunctions()
    {
        return array(
            'qp_convert_currency'       => new \Twig_Function_Method($this, 'convertCurrency', array('is_safe' => array('html'))),
            'qp_get_defined_currency'   => new \Twig_Function_Method($this, 'getDefinedCurrency', array('is_safe' => array('html'))),
        );
    }
    
    public function getFilters()
    {
        return array(
            'qp_format_currency'    => new \Twig_Filter_Method($this, 'formatCurrency', array('is_safe' => array('html'))),
            'qp_filter_symbol'      => new \Twig_Filter_Method($this, 'filterSymbol', array('is_safe' => array('html'))),
            'qp_filter_amount'      => new \Twig_Filter_Method($this, 'filterAmount', array('is_safe' => array('html'))),
        );
    }
    
    /**
     * Conversão de um valor por câmbio.
     * A conversão é realizada junto a provedores definidos por configuração.
     * 
     * @param decimal $amount       Valor a ser convertido
     * @param string $from          Moeda de origem
     * @param string $to            Moeda de destino para conversão
     * @param boolean $format       Formatar a moeda conforme o país de destino?
     * @param string $provider_name Nome do provedor de conversão
     * 
     * @return decimal|string       Valor convertido | convertido && formatado
     * @throws \RuntimeException    Caso o provedor de conversão não tenha sido encontrado
     */
    public function convertCurrency($amount, $from, $to, $format = false, $provider_name = null)
    {
        $provider = (null === $provider_name) ? $this->defaultProvider : $provider_name;
        $object = $this->conversionManager->convert($from, $to, $amount, $provider);
        if (true === $format) {
            $amount = $this->formatCurrency($object->getConvertedAmount(), $to);
        }
        
        return $amount;
    }
    
    /**
     * Formatará um valor conforme a moeda fornecida.
     * 
     * @param decimal $amount
     * @param string $currency
     * @return string
     */
    public function formatCurrency($amount, $currency = null)
    {
        return (null !== $currency) ? $this->currencyFormatter->format($amount, $currency) : $this->currencyFormatter->autoFormat($amount);
    }
    
    /**
     * Através de um valor, o método efetuará o filtro do
     * valor para localizar somente o símbolo deste.
     * 
     * @param mixed $amount
     * @param string $currency
     * @return string
     */
    public function filterSymbol($amount, $currency = null)
    {
        if (true === is_float($amount)) {
            $amount = $this->formatCurrency(floatval($amount), $currency);
        }
        
        return $this->currencyFormatter->parseSymbolByAmount($amount, $currency);
    }
    
    /**
     * Efetua um filtro para retornar somente o valor formatado
     * conforme moeda definida.
     * 
     * @param mixed $amount
     * @param string $currency
     * @return decimal
     */
    public function filterAmount($amount, $currency = null)
    {
        return $this->currencyFormatter->parseAmount($amount, $currency);
    }
    
    /**
     * Localizar o currency já definido.
     * Caso não haja nenhum definido na sessão o sistema
     * localizará o padrão definido pelo locale do usuário.
     * 
     * @return string
     */
    public function getDefinedCurrency()
    {
        $defaultCurrency = $this->currencyStorage->getCurrentCurrency();
        if (null === $defaultCurrency || false === $this->currencyFormatter->isCurrencyValid($defaultCurrency)) {
            $defaultCurrency = $this->currencyFormatter->getCurrencyByLocale();
        }
        
        return $defaultCurrency;
    }
    
    public function getName()
    {
        return 'currency_extension';
    }
    
}