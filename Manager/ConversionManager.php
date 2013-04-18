<?php

namespace Quality\Bundle\CurrencyConverterBundle\Manager;

use Quality\Bundle\CurrencyConverterBundle\Provider\Manager\ProviderManagerInterface;
use Quality\Bundle\CurrencyConverterBundle\Operator\ConversionOperator;
use Doctrine\ORM\EntityManager;

/**
 * ConversionManager
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENSE
 * @copyright (c) 2013
 */
class ConversionManager extends ConversionOperator implements ConversionManagerInterface
{
    
    protected $entityManager;
    protected $providerManager;
    protected $entityClass;
    protected $timeToLive;
    
    public function __construct(EntityManager $manager, ProviderManagerInterface $providerManager, $entityClass, $ttl)
    {
        $this->entityManager = $manager;
        $this->providerManager = $providerManager;
        $this->entityClass = $entityClass;
        $this->timeToLive = $ttl;
    }
    
    public function convert($from, $to, $amount, $provider)
    {
        $this->entityManager->beginTransaction();
        try {
            $conversion = $this->doConversion($provider, $from, $to, $amount);

            if (null === $conversion->getId()) {
                $this->entityManager->persist($conversion);
                $this->entityManager->flush();
                $this->entityManager->commit();
            }

            return $conversion;
        } catch (\Exception $failure) {
            $this->entityManager->rollback();
            $this->entityManager->close();

            throw $failure;
        }
    }
    
    protected function getLastConversion($from, $to)
    {
        $dql = 'SELECT c FROM ' . $this->entityClass . ' c WHERE c.fromCurrency = :from AND c.toCurrency = :to ORDER BY c.registeredAt DESC';
        $parameters = array('from' => $from, 'to' => $to);
        
        return $this->entityManager->createQuery($dql)->setParameters($parameters)->setMaxResults(1)->getOneOrNullResult();
    }

    protected function getTimeToLive()
    {
        return $this->timeToLive;
    }
    
    protected function createConversion()
    {
        $class = $this->entityClass;
        return new $class;
    }
    
    public function getProvider($provider)
    {
        return $this->providerManager->get($provider);
    }
    
}