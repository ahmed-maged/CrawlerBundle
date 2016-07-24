<?php
/**
 * @author: Ahmed Maged
 * Date: 4/26/14 - 3:47 PM
 */

namespace AMaged\CrawlerBundle\Crawlers;


use AMaged\CrawlerBundle\Document\AbstractEntityProperty;
use AMaged\CrawlerBundle\Document\ListingCrawler;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\DomCrawler\Crawler;

class BaseCrawler
{
    /**
     * @var DocumentManager
     */
    protected $dm;

    protected $maxElems2Crawl = null;

    protected $timeLimit = 400;

    /**
     * @param DocumentManager $dm
     */
    function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    public function setTimeLimit($limit)
    {
        $this->timeLimit = $limit;
        return $this;
    }

    public function setMaxElems2Crawl($max)
    {
        $this->maxElems2Crawl = $max;
        return $this;
    }

    public function fixUtf8($elem)
    {
        return htmlentities( (string) $elem, ENT_QUOTES, 'utf-8', FALSE);
    }

    public function getCrawler($url)
    {
        try{
            $html = file_get_contents($url);
        }
        catch(\Exception $e){
            return false;
        }
        return new A3Crawler(new Crawler($html));
    }

    public function fillConfigArray(ListingCrawler $crawler)
    {
        return array(
            'targetClass'=>$crawler->getPageTemplate()->getTargetClass(),
            'targetLinkPrefix'=>$crawler->getPageTemplate()->getTargetLinkPrefix(),
            'targetLinkContainerSelector'=>$crawler->getPageTemplate()->getTargetLinkContainerSelector(),
            'targetSampleContainerSelector'=>$crawler->getPageTemplate()->getTargetSampleContainerSelector(),
            'props'=>$crawler->getPageTemplate()->getPropsArray()
        );
    }

    public function crawlListingAndSinglePage(ListingCrawler $crawler, $maxResults=null)
    {
        set_time_limit($this->timeLimit);

        $this->setMaxElems2Crawl($maxResults);
        $config = $this->fillConfigArray($crawler);

        $listingUrl = $crawler->getListingUrl();

        //many pages will be crawled, loop
        if($listingUrlPagePlaceholder = $crawler->getListingUrlPagePlaceholder()){
            $pageNumber = 1;
            $fourOhFour = false;
            $url = str_replace($listingUrlPagePlaceholder,$pageNumber,$listingUrl);
            if(!$url){
                throw new \Exception('Invalid page placeholder!');
            }
            while(!$fourOhFour){
                $url = str_replace($listingUrlPagePlaceholder,$pageNumber,$listingUrl);
                $config['url'] = $url;
                echo "crawling page ".$pageNumber."<br>";
                $fourOhFour = !$this->doCrawlListingAndSinglePage($config);
                $pageNumber++;
                if($pageNumber >1){
                    $fourOhFour = true;
                }
            }
        }
        elseif($paginationLinkSelector = $crawler->getPageTemplate()->getPaginationLinkSelector()){
            $config['url'] = $nextPageUrl = $listingUrl;
            $config['paginationLinkSelector'] = $paginationLinkSelector;
            while($nextPageUrl){
                $nextPageUrl = $this->doCrawlListingAndSinglePage($config);
            }
        }
        else{
            $this->doCrawlListingAndSinglePage($config);
        }
    }

    protected function doCrawlListingAndSinglePage($config)
    {
        $dm  = $this->dm;
        $crawler = $this->getCrawler($config['url']);

        if($crawler->isEmpty()){
            return false;
        }

        $count = 0;
        $singleElemNode = $crawler->filter($config['targetSampleContainerSelector']->getSelectorValue()); //loop movie divs
        if($maxPrograms2Crawl = $this->maxElems2Crawl){
            $singleElemNode = $singleElemNode->reduce(function (Crawler $node, $i) use($maxPrograms2Crawl) {
                    return $i < $maxPrograms2Crawl;
                });
        }
        $singleElemNode->each(function($node,$i) use($dm,&$count,$config){
                $count++;
                $node = new A3Crawler($node);
echo "crawling movie ".$count."<br>";
                $link = $node->filter($config['targetLinkContainerSelector']->getSelectorValue())->attrOrNull('href');
                if(!$link){
                    return;
                }

                $movieHtml = file_get_contents($config['targetLinkPrefix'].$link);
                //go to movie page
                $crawler = new A3Crawler(new Crawler($movieHtml));

                $doc = new $config['targetClass']();

                /* @var $propData AbstractEntityProperty */
                foreach($config['props'] as $propData){
                    $propName = $propData->getName();
                    if($propData->getType()=='referenceMany'){
                        //loop the subProps for the referenced prop e.g prop=actor, subProp=name
                        foreach($propData->getProps() as $subPropData){
                            $subPropName = $subPropData->getName();
                            $filterFn = ($subPropData->getSelectorType() =='xpath')?'filterXPath':'filter';
                            //setter for the referenceMany property
                            $setterFn = 'set'.ucfirst($propName);
                            
                            //the "many" properties
                            $props = [];
                            //get the properties containers
                            $propsContainer = $crawler->$filterFn($subPropData->getSelector())
                                ->childrenOrString();
                            if($propsContainer){ //if properties exist, set them in the main document
                                $propsContainer->each(function($node,$i) use(&$props, $dm,$propData,$subPropName){
                                        $prop = $dm->getRepository($propData->getTargetClass())->getOrCreateBy(array($subPropName=>strtolower($this->fixUtf8($node->html()))));
                                        $props[] = $prop;
                                    });
                                $doc->$setterFn($props);
                            }
                        }
                    }
                    else{
                        $filterFn = ($propData->getSelectorType() =='xpath')?'filterXPath':'filter';
                        $setterFn = 'set'.ucfirst($propName);
                        $doc->$setterFn(
                            $crawler->$filterFn($propData->getSelectorValue())
                                ->htmlOrString($propData->getDefaultValue())
                        );
                    }
                }
                $dm->persist($doc);
                $dm->flush();
            }
        );

        if(isset($config['paginationLinkSelector'])){
            //return next page
            return $crawler->filter($config['paginationLinkSelector'])->attrOrNull('href'); //loop movie divs
        }
        return true;
    }
}