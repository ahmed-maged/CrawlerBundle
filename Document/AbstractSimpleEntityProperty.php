<?php
/**
 * @author: Ahmed Maged
 * Date: 5/1/14 - 9:31 PM
 */

namespace AMaged\CrawlerBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\InheritanceType;
use Doctrine\ODM\MongoDB\Mapping\Annotations\DiscriminatorField;
use Doctrine\ODM\MongoDB\Mapping\Annotations\DiscriminatorMap;

/**
 * @InheritanceType("SINGLE_COLLECTION")
 * @DiscriminatorField("type")
 * @DiscriminatorMap({"int"="IntFieldMetaData", "string"="StringFieldMetaData"})
 */
class AbstractSimpleEntityProperty extends AbstractEntityProperty
{
    /**
     * @MongoDB\EmbedOne(
     *    targetDocument="Selector"
     * )
     * @var Selector
     */
    protected $selector;

    /**
     * @MongoDB\String
     * @var
     */
    protected $defaultValue;

    /**
     * @param mixed $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @param mixed $selector
     */
    public function setSelector($selector)
    {
        $this->selector = $selector;
    }

    /**
     * @return mixed
     */
    public function getSelector()
    {
        return $this->selector;
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

}