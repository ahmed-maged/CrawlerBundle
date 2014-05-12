<?php

namespace Al3asema\CrawlerBundle\Controller;

use Al3asema\BackendBundle\Form\ProgramType;
use Al3asema\CrawlerBundle\Annotation\HelpReader;
use Al3asema\CrawlerBundle\Document\ListingCrawler;
use Al3asema\CrawlerBundle\Document\Selector;
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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/crawlers")
 */
class CrawlersController extends Controller
{
    /**
     * @param $request
     * @Route("/",name="list_crawlers")
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
        return $this->render('Al3asemaCrawlerBundle:Crawlers:index.html.twig', array('columns' => $columns));
    }

    /**
     * @todo add authentication for roles that can run crawlers, add an extra step?
     * @Route("/run/{crawler}/{maxRes}")
     */
    public function runAction(ListingCrawler $crawler=null, $maxRes)
    {
        /**
         * @koreek to get the referenced doc
         */
        $crawler->getPageTemplate()->getName();
        $this->get('listing_crawler')->crawlListingAndSinglePage($crawler, $maxRes);
        die('done.');
    }

    /**
     *
     * @Route("/new", name="crawler_new")
     * @Template("Al3asemaCrawlerBundle:Crawlers:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $reader = new AnnotationReader();
        $helpReader = new HelpReader($reader);
        $form = $this->createForm(new ListingCrawlerType($helpReader),new ListingCrawler());

        if ($request->getMethod() == 'POST')
        {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $doc = $form->getData();
                $dm = $this->get('doctrine_mongodb')->getManager();
                $dm->persist($doc);
                $dm->flush();
                return $this->redirect($this->generateUrl('list_crawlers'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     *
     * @Route("/edit/{id}", name="crawlers_edit")
     * @Template("Al3asemaCrawlerBundle:Crawlers:new.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $program = $dm->getRepository('Al3asemaCrawlerBundle:Crawler')->find($id);
        $editForm = $this->createForm(new ProgramType(), $program);

        if ($request->getMethod() == 'POST'){
            $editForm->handleRequest($request);

            if ($editForm->isValid()) {
                $dm->persist($program);
                $dm->flush();
                return $this->redirect($this->generateUrl('list_crawlers'));
            }
        }

        return array(
            'entity' => $program,
            'form' => $editForm->createView()
        );
    }

    /**
     *
     * @Route("/delete/{id}", name="crawlers_delete")
     */
    public function deleteAction($id) {

        $dm = $this->get('doctrine_mongodb')->getManager();
        $entity = $dm->getRepository('Al3asemaCrawlerBundle:Crawler')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find entity.');
        }

        $dm->remove($entity);
        $dm->flush();

        return $this->redirect($this->generateUrl('list_crawlers'));
    }

    /**
     * @param $request
     * @Route("/crawlers/ajax",name="crawlers_ajax")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function datatablesAction(Request $request)
    {
        $dataAction = array(
            array(
                'route' => 'crawlers_edit',
                'class' => 'btn btn-primary btn-lg',
                'icon'  => 'fa fa-pencil',
                'title' => 'Edit'
            ),
            array(
                'route' => 'crawlers_delete',
                'class' => 'btn btn-primary btn-lg btn-danger',
                'icon'  => 'fa fa-times',
                'title' => 'delete',
                'attrs' => array(
                    'data-message' => 'Are you sure you want to delete this crawler ?'
                )
            )
        );

        $response  = $this->get('datatable_manager')
            ->setColumns(['_id', 'name', 'targetClass'])
            ->setDataSource($this->get('doctrine_mongodb')->getManager()->getRepository('Al3asema\CrawlerBundle\Document\ListingCrawler'))
            ->datatable($request->query->all(), $dataAction);

        return new JsonResponse($response);
    }
}
