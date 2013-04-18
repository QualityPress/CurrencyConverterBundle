<?php

namespace Quality\Bundle\CurrencyConverterBundle\Helper;

/**
 * CurrencyFormatterInterface
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENSE
 * @copyright (c) 2013
 */
interface CurrencyFormatterInterface
{
    
    /**
     * Formatar valor de acordo com moeda.
     * Efetua a conversão de um valor de acordo com o currency 
     * 
     * O código da moeda deverá ser informado conforme ISO-4217.
     * @see http://www.xe.com/iso4217.php
     * @see http://www.iso.org/iso/home/standards/currency_codes.htm
     * 
     * @param decimal $amount
     * @param string $currency
     * 
     * @return string
     * @return decimal
     */
    function format($amount, $currency);
    
    /**
     * Através da identificação do local do cliente a classe
     * verificará se foi registrado uma conversão para localização
     * do cliente, caso não exista pegará a definida pela configuração.
     * 
     * @param decimal $amount
     * @return decimal
     */
    function autoFormat($amount);
    
    /**
     * Localizará o símbolo monetário de um valor.
     * 
     * @param decimal $amount
     * @param string $currency
     * @return string
     */
    function parseSymbol($amount, $currency = null);
    
    /**
     * Efetuará o filtro para retornar somente o valor formatado da moeda.
     * 
     * @param string $amount
     * @param string $currency
     * @return decimal
     */
    function parseAmount($amount, $currency = null);
    
    /**
     * Efetua a localização da moeda pela cultura.
     * Retornará assim o código internacional da moeda.
     * 
     * O código da moeda será informado conforme ISO-4217.
     * @see http://www.xe.com/iso4217.php
     * @see http://www.iso.org/iso/home/standards/currency_codes.htm
     * 
     * @param string $locale
     * @return string
     */
    function getCurrencyByLocale($locale = null);
    
}