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

class PropertyType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('simple_props','collection',array(
                    'type'=>new SimplePropertyType(),
                    'mapped'=>false,
                    'required'=>false,
                    'allow_add'=>true
                )
            )
            ->add('reference_many_props','collection',array(
                    'type'=>new ReferenceManyPropertyType(),
                    'mapped'=>false,
                    'required'=>false,
                    'allow_add'=>true
                )
            )
            ->add('add_simple_btn','button',array(
                    'label'=>'Add simple prop',
                    'attr'=>array(
                        'class'=>"add-another-simple-prop"
                    ),
                )
            )
            ->add('add_rm_btn','button',array(
                    'label'=>'Add reference many prop',
                    'attr'=>array(
                        'class'=>"add-another-reference-many-prop"
                    ),
                )
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'AMaged\CrawlerBundle\Document\AbstractEntityProperty'
            ));
    }

    public function getName()
    {
        return 'entity_property';
    }
}
