<?php

namespace Mtt\EasyPageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use LittleHouse\EasyPageBundle\Entity\Page;

/**
 * Page controller.
 *
 */
class PageController extends Controller
{
    /**
     * Lists all Page entities.
     *
     */
    public function listAction(Request $request)
    {
        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $this->getPageRepository()->findAllActive(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        // parameters to template
        return $this->render('@easypage_templates/list.html.twig',
            array('pagination' => $pagination)
        );
    }

    /**
     * Finds and displays a Page entity.
     *
     */
    public function showAction(Page $page)
    {
        return $this->render('page/show.html.twig', array(
            'page' => $page,
        ));
    }



    protected function getPageRepository(){
        $em = $this->getDoctrine()->getManager();
        $pageEntity = $this->getParameter('mtt_easy_page.page_entity');
        return $em->getRepository($pageEntity);
    }

}
