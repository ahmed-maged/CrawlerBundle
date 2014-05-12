<?php
/**
 * @author: Ahmed Maged
 * Date: 5/1/14 - 9:31 PM
 */

namespace Al3asema\CrawlerBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="crawler")
 * @MongoDB\InheritanceType("SINGLE_COLLECTION")
 */
class Crawler
{
    /**
     * @MongoDB\Id(strategy="INCREMENT")
     * @var
     */
    protected $id;

    /**
     * @MongoDB\String
     * @var
     */
    protected $name;


    /**
     * @param $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}