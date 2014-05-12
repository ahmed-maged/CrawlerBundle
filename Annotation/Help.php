<?php
/**
 * @author: Ahmed Maged
 * Date: 5/2/14 - 9:30 PM
 */

namespace Al3asema\CrawlerBundle\Annotation;

/**
 * @Annotation
 */
class Help
{
    private $info;

    public function __construct($options)
    {
        if (isset($options['value'])) {
            $options['propertyName'] = $options['value'];
            unset($options['value']);
        }

        foreach ($options as $key => $value) {
            if (!property_exists($this, $key)) {
                throw new \InvalidArgumentException(sprintf('Property "%s" does not exist', $key));
            }

            $this->$key = $value;
        }
    }

    public function getInfo()
    {
        return $this->info;
    }

}