<?php
/**
 * @author: Ahmed Maged
 * Date: 5/3/14 - 10:25 PM
 */

namespace AMaged\CrawlerBundle\Form;

use AMaged\CrawlerBundle\Annotation\HelpReader;
use AMaged\CrawlerBundle\Document\AbstractEntityProperty;
use AMaged\CrawlerBundle\Document\ListingCrawler;
use AMaged\CrawlerBundle\Document\ListingCrawlerPageTemplate;
use AMaged\CrawlerBundle\Form\DataTransformer\ArrayToSelectorTransformer;
use AMaged\CrawlerBundle\Form\Type\DomSelectorType;
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
                'data_class' => 'AMaged\CrawlerBundle\Document\AbstractSimpleEntityProperty'
            ));
    }

    public function getName()
    {
        return 'simple_prop';
    }
}
