<?php

namespace Quality\Bundle\CurrencyConverterBundle\Provider\Manager;

use Quality\Bundle\CurrencyConverterBundle\Provider\ProviderInterface;

/**
 * ProviderManagerInterface
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013
 */
interface ProviderManagerInterface extends \Countable
{
    
    /**
     * Localizar provedores.
     * Verifica todos os provedores registrados.
     * 
     * @return array
     */
    function all();
    
    /**
     * Adiciona provedor a uma lista de provedores.
     * 
     * @param \Quality\Bundle\CurrencyConverterBundle\Provider\ProviderInterface $provider
     * @return void
     */
    function add(ProviderInterface $provider);
    
    /**
     * Localizar um provedor.
     * Através do nome do provedor, esclarecido pelo
     * método getName(), será efetuada uma pesquisa retornando 
     * assim o provedor desejado.
     * 
     * @param string $name
     * @return \Quality\Bundle\CurrencyConverterBundle\Provider\ProviderInterface|null $provider
     */
    function get($name);
    
    /**
     * Verifica a existência de um provedor
     * através do nome enviado por parâmetro.
     * 
     * @param string $name
     * @return boolean
     */
    function has($name);
    
}