<?php

namespace Quality\Bundle\CurrencyConverterBundle\Entity;

use Quality\Bundle\CurrencyConverterBundle\Model\Conversion as BaseConversion;

/**
 * Conversion
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENSE
 * @copyright (c) 2013
 */
class Conversion extends BaseConversion
{
    
    /** @var integer $id */
    protected $id;
    
    /**
     * Localizar id de identificação do registro
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
}