<?php
/**
 * @author: Ahmed Maged
 * Date: 5/3/14 - 11:24 AM
 */

namespace Al3asema\CrawlerBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Al3asema\CrawlerBundle\Annotation\Help;

/**
 * @MongoDB\Document(collection="crawler_page_template")
 */
class ListingCrawlerPageTemplate
{

    /**
     * @MongoDB\Id(strategy="increment")
     * @var
     */
    protected $id;

    /**
     * @MongoDB\String
     * @var
     */
    protected $name;

    /**
     *
     * @Help(
     *  info="Optional, the container element for the 'next page', it must be an anchor.
     *   If given, the next page will be fetched from its href attribute.
     *   Note: if listingUrlPagePlaceholder is not null, this will be ignored."
     * )
     * @MongoDB\EmbedOne(
     *    targetDocument="Selector"
     * )
     * @var Selector
     */
    protected $paginationLinkSelector;

    /**
     * @Help(
     *  info="The link to the actual listing page, with one result. e.g. an actual movie page that needs to be crawled."
     * )
     * @MongoDB\EmbedOne(
     *    targetDocument="Selector"
     * )
     * @var Selector
     */
    protected $targetLinkContainerSelector;

    /**
     * @Help(
     *  info="Optional. If urls are relative, a prefix can be given to prepend to all urls."
     * )
     * @MongoDB\String
     * @var string
     */
    protected $targetLinkPrefix;

    /**
     * @Help(
     *  info="The container that contains some info about each single target.
     *     e.g. a div containing movie title and image."
     * )
     * @MongoDB\EmbedOne(
     *    targetDocument="Selector"
     * )
     * @var Selector
     */
    protected $targetSampleContainerSelector;

    /**
     * @MongoDB\String
     * @var
     */
    protected $targetClass;

    /**
     * @Help(
     *  info="For the actual target page, these are all the properties that need to
     *       be crawled from the actual single result page."
     * )
     * @MongoDB\EmbedMany(
     *  targetDocument="AbstractEntityProperty"
     * )
     * @var array
     */
    protected $props;

    public static $targetClasses = array(
        'Program' =>'Al3asema\CoreBundle\Document\Program',
        'Person'  =>'Al3asema\CoreBundle\Document\Person',
        'Channel' =>'Al3asema\CoreBundle\Document\Channel',
        'Session' =>'Al3asema\CoreBundle\Document\Session',
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
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param \Al3asema\CrawlerBundle\Document\Selector $paginationLinkSelector
     */
    public function setPaginationLinkSelector($paginationLinkSelector)
    {
        $this->paginationLinkSelector = $paginationLinkSelector;
    }

    /**
     * @return \Al3asema\CrawlerBundle\Document\Selector
     */
    public function getPaginationLinkSelector()
    {
        return $this->paginationLinkSelector;
    }

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
     * @return mixed
     */
    public function getPropsArray()
    {
        return $this->props;
    }

    /**
     * @param \Al3asema\CrawlerBundle\Document\Selector $targetLinkContainerSelector
     */
    public function setTargetLinkContainerSelector($targetLinkContainerSelector)
    {
        $this->targetLinkContainerSelector = $targetLinkContainerSelector;
    }

    /**
     * @return \Al3asema\CrawlerBundle\Document\Selector
     */
    public function getTargetLinkContainerSelector()
    {
        return $this->targetLinkContainerSelector;
    }

    /**
     * @param string $targetLinkPrefix
     */
    public function setTargetLinkPrefix($targetLinkPrefix)
    {
        $this->targetLinkPrefix = $targetLinkPrefix;
    }

    /**
     * @return string
     */
    public function getTargetLinkPrefix()
    {
        return $this->targetLinkPrefix;
    }

    /**
     * @param \Al3asema\CrawlerBundle\Document\Selector $targetSampleContainerSelector
     */
    public function setTargetSampleContainerSelector($targetSampleContainerSelector)
    {
        $this->targetSampleContainerSelector = $targetSampleContainerSelector;
    }

    /**
     * @return \Al3asema\CrawlerBundle\Document\Selector
     */
    public function getTargetSampleContainerSelector()
    {
        return $this->targetSampleContainerSelector;
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