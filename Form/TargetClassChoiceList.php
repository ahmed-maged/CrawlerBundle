<?php
/**
 * @author: Ahmed Maged
 * Date: 5/2/14 - 12:35 PM
 */

namespace AMaged\CrawlerBundle\Form;


use AMaged\CrawlerBundle\Document\Crawler;
use AMaged\CrawlerBundle\Document\ListingCrawlerPageTemplate;
use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

class TargetClassChoiceList extends LazyChoiceList
{

    protected function loadChoiceList()
    {
        return new SimpleChoiceList(array_flip(ListingCrawlerPageTemplate::$targetClasses));
    }
} 