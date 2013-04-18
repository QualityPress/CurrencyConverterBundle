<?php

namespace Quality\Bundle\CurrencyConverterBundle\Storage;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * CurrencySession
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENSE
 * @copyright (c) 2013
 */
class CurrencyStorage
{
    
    const DEFAULT_KEY = '_qualitypress.current-currency';
    
    protected $key;
    protected $session;
    
    public function __construct(SessionInterface $session, $key = self::DEFAULT_KEY)
    {
        $this->session = $session;
        $this->key = $key;
    }
    
    public function getCurrentCurrency()
    {
        return $this->session->get($this->key);
    }
    
    public function setCurrentCurrency($currency)
    {
        $this->session->set($this->key, strtoupper($currency));
    }
    
    public function resetCurrentCurrency()
    {
        $this->session->remove($this->key);
    }
    
}