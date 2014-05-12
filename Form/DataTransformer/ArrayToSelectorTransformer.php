<?php
/**
 * @author: Ahmed Maged
 * Date: 5/3/14 - 12:25 AM
 */

namespace Al3asema\CrawlerBundle\Form\DataTransformer;


use Al3asema\CrawlerBundle\Document\Selector;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;

class ArrayToSelectorTransformer implements DataTransformerInterface
{
    public function reverseTransform($selectorArray)
    {
        if (null === $selectorArray) {
            return "";
        }
        $selector = new Selector();
        $selector->setSelectorType($selectorArray['selectorType']);
        $selector->setSelectorValue($selectorArray['selectorValue']);

        return $selector;
    }

    public function transform($selector)
    {
        if(null === $selector){
            return [];
        }
        return array(
            'selectorType'=>$selector->getSelectorType(),
            'selectorValue'=>$selector->getSelectorValue()
        );
    }
} 