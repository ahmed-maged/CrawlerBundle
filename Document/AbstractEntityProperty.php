<?php
/**
 * @author: Ahmed Maged
 * Date: 5/1/14 - 9:31 PM
 */

namespace AMaged\CrawlerBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\EmbeddedDocument
 */
class AbstractEntityProperty
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
    protected $type;

    /**
     * @MongoDB\String
     * @var
     */
    protected $name;

    public static $availableTypes = array(
        'string',
        'int',
        'referenceMany'
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
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }
}