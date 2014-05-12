<?php
/**
 * @author: Ahmed Maged
 * Date: 5/2/14 - 12:35 PM
 */

namespace Al3asema\CrawlerBundle\Form;


use Al3asema\CrawlerBundle\Document\Crawler;
use Al3asema\CrawlerBundle\Document\ListingCrawlerPageTemplate;
use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

class TargetClassChoiceList extends LazyChoiceList
{

    protected function loadChoiceList()
    {
        return new SimpleChoiceList(array_flip(ListingCrawlerPageTemplate::$targetClasses));
    }
} 