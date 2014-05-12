<?php
/**
 * @author: Ahmed Maged
 * Date: 5/2/14 - 2:33 PM
 */

namespace Al3asema\CrawlerBundle\Form\Type;

use Al3asema\CrawlerBundle\Form\DataTransformer\ArrayToSelectorTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Al3asema\CrawlerBundle\Document\Selector;

class DomSelectorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new ArrayToSelectorTransformer();
        $builder
            ->add('selectorValue','text',array('required'=>true))
            ->add('selectorType','choice',array('choices'=>Selector::$selectorTypes));
        $builder->addModelTransformer($transformer);
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'dom_selector';
    }
}
