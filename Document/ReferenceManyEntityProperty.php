<?php
/**
 * @author: Ahmed Maged
 * Date: 5/1/14 - 9:31 PM
 */

namespace Al3asema\CrawlerBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 */
class ReferenceManyEntityProperty extends AbstractEntityProperty
{
    /**
     * @MongoDB\String
     * @var
     */
    protected $targetClass;

    /**
     * @MongoDB\EmbedMany(
     *      targetDocument="AbstractEntityFieldMarkupData"
     * )
     * @var
     */
    protected $props;

    /**
     * @param mixed $props
     */
    public function setProps($props)
    {
        $this->props = $props;
    }

    /**
     * @return mixed
     */
    public function getProps()
    {
        return $this->props;
    }

    /**
     * @param mixed $targetClass
     */
    public function setTargetClass($targetClass)
    {
        $this->targetClass = $targetClass;
    }

    /**
     * @return mixed
     */
    public function getTargetClass()
    {
        return $this->targetClass;
    }
}