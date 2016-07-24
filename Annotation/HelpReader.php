<?php
/**
 * @author: Ahmed Maged
 * Date: 5/2/14 - 10:35 PM
 */

namespace AMaged\CrawlerBundle\Annotation;


use Doctrine\Common\Annotations\Reader;

class HelpReader
{
    /**
     * @var \Doctrine\Common\Annotations\Reader
     */
    public $reader;

    public $annotationClass = 'AMaged\\CrawlerBundle\\Annotation\\Help';

    function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function getHelp($originalObject)
    {
        $reflectionObject = new \ReflectionObject($originalObject);

        $ret = array();
        foreach ($reflectionObject->getProperties() as $reflectionProp) {
            $annotation = $this->reader->getPropertyAnnotation($reflectionProp, $this->annotationClass);
            $ret[$reflectionProp->getName()] = (null !== $annotation)?$annotation->getInfo():"";
        }

        return $ret;
    }
}