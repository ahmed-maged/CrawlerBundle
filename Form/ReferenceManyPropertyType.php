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

class ReferenceManyPropertyType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text',array('mapped'=>true,'required'=>false))
            ->add('targetClass','choice',array(
                    'mapped'=>true,
                    'required'=>true,
                    'choice_list'=>new TargetClassChoiceList()
                )
            )
            ->add('props','collection',array(
                    'type'=> new PropertyType(),
                    'mapped'=>true,
                    'required'=>true,
                )
            )
            ->add('submit','submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'AMaged\CrawlerBundle\Document\ReferenceManyEntityProperty'
            ));
    }

    public function getName()
    {
        return 'listing_crawler';
    }
}
