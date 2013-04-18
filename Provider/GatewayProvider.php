<?php

namespace Quality\Bundle\CurrencyConverterBundle\Provider;

use Quality\Bundle\CurrencyConverterBundle\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * GatewayProvider
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013
 */
abstract class GatewayProvider extends Provider
{    
    
    protected $curlOptions;
    
    public function __construct()
    {
        if (!function_exists('curl_init')) {
            throw new \RuntimeException('The cURL PHP Extension is not accessible, please activate it first.');
        }
        
        $this->curlOptions = array();
    }
    
    /**
     * Adiciona uma propriedade para se juntar as opções
     * que serão enviadas via requisição cURL
     * 
     * @param string $name
     * @param string $value
     */
    public function addCurlOption($name, $value)
    {        
        $this->curlOptions[$name] = $value;
        return $this;
    }
    
    /**
     * Localiza as opções cURL já definidas
     * 
     * @return array
     */
    public function getCurlOptions()
    {
        return $this->curlOptions;
    }
    
    /**
     * Através do bind de request ocorrerá uma conexão curl ao servidor
     * de destino, trazendo como resultado a resposta da rede.
     * 
     * -> Há um bug na função curl_getinfo($curl, CURLINFO_HEADER_SIZE) no qual 
     * foi corrigido somente na versão 5.4.10 se não me engano, portanto manterei
     * $originalHeaders inicialmente como false.
     * 
     * @param \Quality\Bundle\CurrencyConverterBundle\Http\Request
     * @param boolean $originalHeaders Manter headers originais
     * @param boolean $followLocation Seguir caminho
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \RuntimeException
     */
    public function bind(Request $request, $originalHeaders = false, $followLocation = true)
    {        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, $this->getCurlOptions());
        curl_setopt($curl, CURLOPT_URL, $request->getDestiny());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, $followLocation);
        curl_setopt($curl, CURLOPT_HEADER, $originalHeaders);
        
        // Efetua a criação do cabeçalho para requisição
        $requestHeaders = array();
        foreach ($request->headers->all() as $name => $value) {
            if (is_array($value)) {
                foreach ($value as $subValue)
                    $requestHeaders[] = sprintf('%s: %s', $name, $subValue);
            } else {
                $requestHeaders[] = sprintf('%s: %s', $name, $value);
            }
        }
        if (count($requestHeaders)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $requestHeaders);
        }
        
        // Especificações por método de requisição
        $method = strtoupper($request->getMethod());
        switch ($method) {
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, true);
                if (false == $request->headers->has('Content-Type') || 'multipart/form-data' !== $request->headers->get('Content-Type'))
                    $postFields = http_build_query($request->request->all());
                else
                    $postFields = $request->request->all();
                
                curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);
                break;
            
            case 'PUT':
                curl_setopt($curl, CURLOPT_PUT, true);
                break;
                
        }
        
        // Verifica erro na conexão
        if (false === $return = curl_exec($curl)) {
            throw new \RuntimeException(
                sprintf('Error on trying to connect via cURL library. cURL Error: %s: %s', curl_error($curl), curl_errno($curl))
            );
        }
        
        // Criação de cabeçalho para a resposta do transporte
        $headerLimit = (true === $originalHeaders) ? curl_getinfo($curl, CURLINFO_HEADER_SIZE) : 0;
        $responseHeaders = array();
        if (preg_match_all('#^([^:\r\n]+):\s+([^\n\r]+)#m', substr($return, 0, $headerLimit), $matches)) {
            foreach ($matches[1] as $key => $name) {
                $responseHeaders[$name] = $matches[2][$key];
            }
        }
        
        $response = new Response(substr($return, $headerLimit), curl_getinfo($curl, CURLINFO_HTTP_CODE), $responseHeaders);
        curl_close($curl);
        
        return $response;
    }
    
}