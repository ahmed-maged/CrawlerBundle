<?php
/**
 * @author: Ahmed Maged
 * Date: 5/2/14 - 11:26 AM
 */

namespace AMaged\CrawlerBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\EmbeddedDocument
 */
class Selector
{
    /**
     * @MongoDB\Id(strategy="INCREMENT")
     * @var
     */
    protected $id;

    /**
     * @MongoDB\String
     * @var
     */
    protected $selectorValue;

    /**
     * @MongoDB\String
     * @var
     */
    protected $selectorType;

    public static $selectorTypes = array(
        'css',
        'xpath'
    );

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $selectorType
     */
    public function setSelectorType($selectorType)
    {
        $this->selectorType = $selectorType;
    }

    /**
     * @return mixed
     */
    public function getSelectorType()
    {
        return $this->selectorType;
    }

    /**
     * @param mixed $selectorValue
     */
    public function setSelectorValue($selectorValue)
    {
        $this->selectorValue = $selectorValue;
    }

    /**
     * @return mixed
     */
    public function getSelectorValue()
    {
        return $this->selectorValue;
    }

} 