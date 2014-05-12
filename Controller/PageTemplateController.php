<?php

namespace Al3asema\CrawlerBundle\Controller;

use Al3asema\BackendBundle\Form\ProgramType;
use Al3asema\CrawlerBundle\Annotation\Help;
use Al3asema\CrawlerBundle\Annotation\HelpReader;
use Al3asema\CrawlerBundle\Document\ListingCrawlerPageTemplate;
use Al3asema\CrawlerBundle\Document\ListingCrawler;
use Al3asema\CrawlerBundle\Document\Selector;
use Al3asema\CrawlerBundle\Form\ListingCrawlerPageTemplateType;
use Al3asema\CrawlerBundle\Form\ListingCrawlerType;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Al3asema\CrawlerBundle\Document\Crawler as CrawlerDoc;

/**
 * @Route("/pageTemplates")
 */
class PageTemplateController extends Controller
{
    /**
     * @param $request
     * @Route("/",name="list_page_templates")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $columns = array(
            'id',
            'name',
            'targetClass',
            'Actions'
        );
        return $this->render('Al3asemaCrawlerBundle:PageTemplates:index.html.twig', array('columns' => $columns));
    }

    /**
     *
     * @Route("/new", name="page_template_new")
     * @Template("Al3asemaCrawlerBundle:PageTemplates:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $reader = new AnnotationReader();
        $helpReader = new HelpReader($reader);
        $form = $this->createForm(new ListingCrawlerPageTemplateType(($helpReader),new ListingCrawlerPageTemplate()));

        if ($request->getMethod() == 'POST')
        {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $doc = $form->getData();
                $dm = $this->get('doctrine_mongodb')->getManager();
                $dm->persist($doc);
                $dm->flush();
                return $this->redirect($this->generateUrl('list_page_templates'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     *
     * @Route("/edit/{id}", name="page_templates_edit")
     * @Template("Al3asemaCrawlerBundle:PageTemplates:new.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $program = $dm->getRepository('Al3asemaCrawlerBundle:ListingCrawlerPageTemplate')->find($id);
        $reader = new AnnotationReader();
        $helpReader = new HelpReader($reader);
        $editForm = $this->createForm(new ListingCrawlerPageTemplateType($helpReader), $program);

        if ($request->getMethod() == 'POST'){
            $editForm->handleRequest($request);

            if ($editForm->isValid()) {
                die(var_dump(count($program->getProps())));
                $dm->persist($program);
                $dm->flush();
                return $this->redirect($this->generateUrl('list_page_templates'));
            }
        }

        return array(
            'entity' => $program,
            'form' => $editForm->createView()
        );
    }

    /**
     *
     * @Route("/delete/{id}", name="page_templates_delete")
     */
    public function deleteAction($id) {

        $dm = $this->get('doctrine_mongodb')->getManager();
        $entity = $dm->getRepository('Al3asemaCrawlerBundle:ListingCrawlerPageTemplate')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find entity.');
        }

        $dm->remove($entity);
        $dm->flush();

        return $this->redirect($this->generateUrl('list_page_templates'));
    }

    /**
     * @param $request
     * @Route("/pageTemplates/ajax",name="page_templates_ajax")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function datatablesAction(Request $request)
    {
        $dataAction = array(
            array(
                'route' => 'page_templates_edit',
                'class' => 'btn btn-primary btn-lg',
                'icon'  => 'fa fa-pencil',
                'title' => 'Edit'
            ),
            array(
                'route' => 'page_templates_delete',
                'class' => 'btn btn-primary btn-lg btn-danger',
                'icon'  => 'fa fa-times',
                'title' => 'delete',
                'attrs' => array(
                    'data-message' => 'Are you sure you want to delete this page template ?'
                )
            )
        );

        $response  = $this->get('datatable_manager')
            ->setColumns(['_id', 'name', 'targetClass'])
            ->setDataSource($this->get('doctrine_mongodb')->getManager()->getRepository('Al3asema\CrawlerBundle\Document\ListingCrawlerPageTemplate'))
            ->datatable($request->query->all(), $dataAction);

        return new JsonResponse($response);
    }
}
