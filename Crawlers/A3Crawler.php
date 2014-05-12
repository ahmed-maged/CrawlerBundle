<?php
/**
 * @author: Ahmed Maged
 * Date: 4/26/14 - 4:39 PM
 */

namespace Al3asema\CrawlerBundle\Crawlers;


use Symfony\Component\DomCrawler\Crawler;


/**
 * A decorator for Symfony Crawler
 *
 * @package Al3asema\CoreBundle\Crawlers
 */
class A3Crawler
{
    /**
     * @var Crawler
     */
    protected $crawler;

    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * Calls a function from the decorated crawler.
     * If the return value is itself a crawler, the return value is decorated before it is returned
     *
     * @param $name
     * @param $args
     *
     * @return A3Crawler|mixed
     * @throws \Exception
     */
    function __call($name, $args)
    {
        if(method_exists($this->crawler, $name)){
            $return = call_user_func_array(array($this->crawler,$name),$args);
            if($return instanceof Crawler){
                $return = new A3Crawler($return);
            }
            return $return;
        }

        throw new \Exception('method '.$name.' does not exist!');
    }

    public function isEmpty()
    {
        return !count($this->crawler);
    }

    public function htmlOrString($string='N/A')
    {
        return count($this->crawler)?$this->crawler->html():$string;
    }

    public function childrenOrString($string=null)
    {
        return count($this->crawler)?$this->crawler->children():$string;
    }

    public function attrOrNull($attr)
    {
        return count($this->crawler)?$this->crawler->attr($attr):null;
    }
}