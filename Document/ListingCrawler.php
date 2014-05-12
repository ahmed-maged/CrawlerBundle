<?php
/**
 * @author: Ahmed Maged
 * Date: 5/1/14 - 9:31 PM
 */

namespace Al3asema\CrawlerBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Al3asema\CrawlerBundle\Annotation\Help;

/**
 * @MongoDB\Document
 */
class ListingCrawler extends Crawler
{
    /**
     * @Help(
     *  info="The main url containing search results or any other results"
     * )
     * @MongoDB\String
     * @var string
     */
    protected $listingUrl;

    /**
     * @Help(
     *  info="Optional, you can write a pattern in the listingUrl that would be replaced
     *     by page numbers, if given, the crawler will keep replacing the placeholder
     *     with incrementing integers until a 404 is reached"
     * )
     * @MongoDB\String
     * @var
     */
    protected $listingUrlPagePlaceholder;

    /**
     * @Help(
     *  info="The template holding the information about what to be crawled and how"
     * )
     * @MongoDB\ReferenceOne(
     *  targetDocument="ListingCrawlerPageTemplate",
     *  simple="true"
     * )
     * @var
     */
    protected $pageTemplate;

    /**
     * @param mixed $listingUrl
     */
    public function setListingUrl($listingUrl)
    {
        $this->listingUrl = $listingUrl;
    }

    /**
     * @return mixed
     */
    public function getListingUrl()
    {
        return $this->listingUrl;
    }

    /**
     * @param mixed $listingUrlPagePlaceholder
     */
    public function setListingUrlPagePlaceholder($listingUrlPagePlaceholder)
    {
        $this->listingUrlPagePlaceholder = $listingUrlPagePlaceholder;
    }

    /**
     * @return mixed
     */
    public function getListingUrlPagePlaceholder()
    {
        return $this->listingUrlPagePlaceholder;
    }

    /**
     * @param mixed $pageTemplate
     */
    public function setPageTemplate($pageTemplate)
    {
        $this->pageTemplate = $pageTemplate;
    }

    /**
     * @return ListingCrawlerPageTemplate
     */
    public function getPageTemplate()
    {
        return $this->pageTemplate;
    }

}