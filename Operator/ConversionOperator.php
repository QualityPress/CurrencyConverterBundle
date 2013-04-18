<?php

namespace Quality\Bundle\CurrencyConverterBundle\Operator;

use Quality\Bundle\CurrencyConverterBundle\Provider\ProviderInterface;
use Quality\Bundle\CurrencyConverterBundle\Model\ConversionInterface;

/**
 * ConversionOperator
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013
 */
abstract class ConversionOperator implements ConversionOperatorInterface
{
    
    /**
     * Criar objeto de conversão
     * O método filho a este deverá obrigatoriamente implementar
     * esta função para gerar a classe de conversão.
     * 
     * @return ConversionInterface
     */
    protected abstract function createConversion();
    
    /**
     * Efetua a localização do provedor através do nome de identificação.
     * 
     * @return ProviderInterface
     */
    protected abstract function getProvider($name);
    
    /**
     * Verifica o tempo definido para sobrevivência de uma pesquisa. 
    * 
     * @return integer
     */
    protected abstract function getTimeToLive();
    
    /**
     * Localizar última conversão.
     * Método para efetuar a localização da última conversão
     * junto ao banco de dados, decidindo assim a verificação
     * ou não de uma nova consulta junto ao provedor.
     * 
     * @return null|ConversionInterface
     */
    protected abstract function getLastConversion($from, $to);
    
    public function doConversion($provider, $from, $to, $amount)
    {
        if (1 === bccomp(1, $amount)) {
            throw new \OutOfBoundsException(sprintf(
                'O valor fornecido "%s" deve ser um ou maior.',
                $amount
            ));
        }
        
        // Verificar última consulta
        if (null !== $conversion = $this->getLastConversion($from, $to)) {
            $datetime   = new \DateTime("UTC");
            $time       = $datetime->getTimestamp();
            
            // Caso o intervalo de consulta não tenha vencido, retornar última consulta
            if ($time - $this->getTimeToLive() < $conversion->getRegisteredAt()->getTimestamp()) {
                $converted = number_format($amount / $conversion->getRate(), 5, '.', '');
                $conversion->setAmount($amount);
                $conversion->setConvertedAmount($converted);
                
                return $conversion;
            }
        }
        
        // Junto ao provedor, localizar o valor convertido
        $provider = $this->getProvider($provider);
        $convertedAmount = $provider->convert($from, $to, $amount);
        $rate = $amount / $convertedAmount;
        
        // Efetuar a criação do objeto de conversão
        $conversion = $this->createConversion();
        $conversion
            ->setFromCurrency($from)
            ->setToCurrency($to)
            ->setAmount($amount)
            ->setConvertedAmount($convertedAmount)
            ->setRate($rate)
        ;
        
        return $conversion;
    }
    
}