<?php
/**
 * @author: Ahmed Maged
 * Date: 5/3/14 - 10:25 PM
 */

namespace Al3asema\CrawlerBundle\Form;

use Al3asema\CrawlerBundle\Annotation\HelpReader;
use Al3asema\CrawlerBundle\Document\AbstractEntityProperty;
use Al3asema\CrawlerBundle\Document\ListingCrawler;
use Al3asema\CrawlerBundle\Document\ListingCrawlerPageTemplate;
use Al3asema\CrawlerBundle\Form\DataTransformer\ArrayToSelectorTransformer;
use Al3asema\CrawlerBundle\Form\Type\DomSelectorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SimplePropertyType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text',array('mapped'=>true,'required'=>false))
            ->add('selector','dom_selector',array('mapped'=>true,'required'=>true))
            ->add('defaultValue','text',array('mapped'=>true,'required'=>true))
//            ->add('type','choice',array(
//                    'mapped'=>true,
//                    'required'=>true,
//                    'choices'=>AbstractEntityProperty::$availableTypes
//                )
//            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'Al3asema\CrawlerBundle\Document\AbstractSimpleEntityProperty'
            ));
    }

    public function getName()
    {
        return 'simple_prop';
    }
}
