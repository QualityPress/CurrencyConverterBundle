<?php

namespace Quality\Bundle\CurrencyConverterBundle\Model;

/**
 * Conversion
 * 
 * Classe com conteúdos de conversões realizadas junto aos provedores.
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENSE
 * @copyright (c) 2013
 */
abstract class Conversion implements ConversionInterface
{
    
    protected $fromCurrency;
    protected $toCurrency;
    protected $amount;
    protected $convertedAmount;
    protected $rate;
    protected $registeredAt;
    
    public function __construct()
    {
        $this->amount = 0.00;
        $this->convertedAmount = 0.00;
        $this->rate = 0.00;
        $this->registeredAt = new \DateTime('UTC');
    }
    
    public function getFromCurrency()
    {
        return $this->fromCurrency;
    }

    public function setFromCurrency($fromCurrency)
    {
        $this->fromCurrency = $fromCurrency;
        return $this;
    }

    public function getToCurrency()
    {
        return $this->toCurrency;
    }

    public function setToCurrency($toCurrency)
    {
        $this->toCurrency = $toCurrency;
        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function getConvertedAmount()
    {
        return $this->convertedAmount;
    }

    public function setConvertedAmount($convertedAmount)
    {
        $this->convertedAmount = $convertedAmount;
        return $this;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function setRate($rate)
    {
        $this->rate = $rate;
        return $this;
    }

    public function getRegisteredAt()
    {
        return $this->registeredAt;
    }
    
}