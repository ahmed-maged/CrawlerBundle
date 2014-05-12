<?php

namespace Al3asema\CrawlerBundle\Form;

use Al3asema\CrawlerBundle\Annotation\HelpReader;
use Al3asema\CrawlerBundle\Document\ListingCrawler;
use Al3asema\CrawlerBundle\Document\ListingCrawlerPageTemplate;
use Al3asema\CrawlerBundle\Form\DataTransformer\ArrayToSelectorTransformer;
use Al3asema\CrawlerBundle\Form\Type\DomSelectorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ListingCrawlerType extends AbstractType
{
    public $helpInfo;

    public function __construct(HelpReader $reader)
    {
        $this->helpInfo = $reader->getHelp(new ListingCrawler());
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text',array('mapped'=>true,'required'=>false))
            ->add('listingUrl','text',array(
                    'mapped'=>true,
                    'required'=>true,
                    'attr'=>array(
                        'data-help'=>$this->helpInfo['listingUrl']
                    )
                )
            )
            ->add('listingUrlPagePlaceholder','text',array(
                    'mapped'=>true,
                    'required'=>false,
                    'attr'=>array(
                        'data-help'=>$this->helpInfo['listingUrlPagePlaceholder']
                    )
                )
            )
            ->add('pageTemplate', 'genemu_jqueryselect2_document', array(
                    'label' => 'Page Template',
                    'mapped'=>true,
                    'class'=>'Al3asemaCrawlerBundle:ListingCrawlerPageTemplate',
                    'property'=>'name',
                    'multiple'=>false,
                    'required'=>false,
                    'empty_value' => 'Select template',
                    'configs' => array(
                        'width' => '300px',
                    ),
                    'attr'=>array(
                        'data-help'=>$this->helpInfo['pageTemplate']
                    )
                )
            )
            ->add('submit','submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Al3asema\CrawlerBundle\Document\ListingCrawler'
        ));
    }

    public function getName()
    {
        return 'listing_crawler';
    }
}
