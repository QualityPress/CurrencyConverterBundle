<?php

namespace Quality\Bundle\CurrencyConverterBundle\Model;

/**
 * ConversionInterface
 * 
 * Interface para definir quais são as funções
 * que a classe de conversão deverá conter.
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013
 */
interface ConversionInterface
{
    
    /**
     * Definir "de moeda".
     * Método para definir "de qual moeda" (origem) será definida para 
     * realização da pesquisa junto ao provedor.
     * 
     * Lembrando que a moeda fornecida deve ser de acordo com seu
     * código junto a ISO-4217.
     * 
     * Para mais detalhes
     * @link http://www.iso.org/iso/home/standards/currency_codes.htm
     * @link http://www.xe.com/iso4217.php
     * 
     * @param string $currency
     * @return self
     */
    function setFromCurrency($currency);
    
    /**
     * Localizar moeda definida.
     * Código da moeda referente a seu código junto a ISO-4217.
     * 
     * @return string
     */
    function getFromCurrency();
    
    /**
     * Definir destino de conversão.
     * Método para definir destino da moeda de conversão.
     * 
     * Lembrando que a moeda fornecida deve ser de acordo com seu
     * código junto a ISO-4217.
     * 
     * Para mais detalhes
     * @link http://www.iso.org/iso/home/standards/currency_codes.htm
     * @link http://www.xe.com/iso4217.php
     * 
     * @param string $currency
     * @return self
     */
    function setToCurrency($currency);
    
    /**
     * Buscar a moeda de destino.
     * Localizar a moeda no qual o valor deverá ser convertido.
     * 
     * @return string
     */
    function getToCurrency();
    
    /**
     * Definir montante.
     * Método para setar o montante a ser convertido.
     * 
     * @param decimal $amount
     * @return self
     */
    function setAmount($amount);
    
    /**
     * Localizar montate.
     * Verificar qual o montante que foi definido para conversão.
     * 
     * @return decimal
     */
    function getAmount();
    
    /**
     * Definir valor convertido.
     * Seta qual o valor retornado pelo provedor para a conversão.
     * 
     * @param decimal $amount
     * @return self
     */
    function setConvertedAmount($amount);
    
    /**
     * Verificar valor convertido.
     * Localiza qual o valor armazenado retornado pelo provedor.
     * 
     * @return decimal
     */
    function getConvertedAmount();
    
    /**
     * Definir o rate (variação) de conversão.
     * Rate servirá para consultas via "cache database"
     * 
     * @param decimal $rate
     * @return self
     */
    function setRate($rate);
    
    /**
     * Localizar rate (variação) de conversão.
     * Método para localizar qual o rate de conversão,
     * facilitando assim futuras consultas.
     * 
     * @return decimal
     */
    function getRate();
    
    /**
     * Data de registro.
     * Verifica qual foi a data de registro da consulta.
     * 
     * @return \DateTime
     */
    function getRegisteredAt();
    
}