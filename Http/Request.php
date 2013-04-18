<?php

namespace Quality\Bundle\CurrencyConverterBundle\Http;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\HeaderBag;

/**
 * Request
 * 
 * Classe específica para criação de requisições externas.
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENSE
 * @copyright (c) 2013
 */
class Request
{
    
    protected $destiny;
    protected $method;
    public $request;
    public $headers;
    
    /**
     * Construtor.
     * Definir parâmetros iniciais para requisição.
     * 
     * @param string $destiny   URL de destino
     * @param string $method    Método para envio de informações
     * @param array $request    Parâmetros de requisição
     * @param array $headers    Parâmetros para inserir no cabeçalho da requisição
     */
    function __construct($destiny, $method = 'POST', $request = array(), $headers = array())
    {
        $this->destiny = $destiny;
        $this->method = $method;
        $this->request = new ParameterBag($request);
        $this->headers = new HeaderBag($headers);
    }
    
    public function getDestiny()
    {
        return $this->destiny;
    }

    public function getMethod()
    {
        return $this->method;
    }
    
}