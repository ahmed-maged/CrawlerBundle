<?php

namespace AMaged\CrawlerBundle\Form;

use AMaged\CrawlerBundle\Annotation\HelpReader;
use AMaged\CrawlerBundle\Document\ListingCrawlerPageTemplate;
use AMaged\CrawlerBundle\Document\ListingCrawler;
use AMaged\CrawlerBundle\Form\DataTransformer\ArrayToSelectorTransformer;
use AMaged\CrawlerBundle\Form\Type\DomSelectorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ListingCrawlerPageTemplateType extends AbstractType
{
    public $helpInfo;

    public function __construct(HelpReader $reader)
    {
        $this->helpInfo = $reader->getHelp(new ListingCrawlerPageTemplate());
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text',array('mapped'=>true,'required'=>false))
            ->add('targetClass','choice',array(
                    'choice_list'=>new TargetClassChoiceList(),
                    'mapped'=>true,
                    'required'=>false,
                    'attr'=>array(
                        'data-help'=>$this->helpInfo['targetClass']
                    )
                )
            )
            ->add('targetLinkPrefix','text',array(
                    'mapped'=>true,
                    'required'=>false,
                    'attr'=>array(
                        'data-help'=>$this->helpInfo['targetLinkPrefix']
                    )
                )
            )
            ->add('paginationLinkSelector','dom_selector',array(
                    'mapped'=>true,
                    'required'=>false,
                    'label'=>'Pagination Link Selector',
                    'attr'=>array(
                        'data-help'=>$this->helpInfo['paginationLinkSelector']
                    )
                )
            )
            ->add('targetLinkContainerSelector','dom_selector',array(
                    'mapped'=>true,
                    'required'=>false,
                    'label'=>'Target Link Container Selector',
                    'attr'=>array(
                        'data-help'=>$this->helpInfo['targetLinkContainerSelector']
                    )
                )
            )
            ->add('targetSampleContainerSelector','dom_selector',array(
                    'mapped'=>true,
                    'required'=>false,
                    'label'=>'Target Sample Container Selector',
                    'attr'=>array(
                        'data-help'=>$this->helpInfo['targetSampleContainerSelector']
                    )
                )
            )
            ->add('props',new PropertyType(),array(
                    'mapped'=>false,
                    'required'=>false,
                    'label'=>'Properties to fill'
                ))
            ->add('submit','submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AMaged\CrawlerBundle\Document\ListingCrawlerPageTemplate'
        ));
    }

    public function getName()
    {
        return 'crawler_page_template';
    }
}
