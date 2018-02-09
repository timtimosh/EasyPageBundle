<?php

namespace Mtt\EasyPageBundle\Controller;

use Mtt\EasyPageBundle\Entity\BasePage;
use Mtt\EasyPageBundle\Repository\BasePageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use Mtt\EasyPageBundle\Entity\PageEntityInterface;

/**
 * Page controller.
 *
 */
class PageController extends Controller
{
    protected function getLimit()
    {
        return 10;
    }

    /**
     * Lists all Page entities.
     *
     */
    public function listAction(Request $request)
    {
        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $this->getPageRepository()->findActive(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $this->getLimit()/*limit per page*/
        );

        // parameters to template
        return $this->render('@easypage_templates/list.html.twig',
            array('pagination' => $pagination)
        );
    }

    /**
     * Finds and displays a Page entity.
     * @var $page BasePage
     *
     */
    public function showAction($slug)
    {
        $page = $this->getPageRepository()->findOneActiveBySlug($slug);
        if (!$page) {
            throw $this->createNotFoundException('The page does not exist');
        }
        $view = $this->getSinglePageTemplate($page);
        return $this->render($view, array(
            'page' => $page,
        ));
    }

    protected function getSinglePageTemplate($page):string {
        if (null === $page->getPageTemplate() || '' === $page->getPageTemplate()) {
            $view = '@easypage_templates/show.html.twig';
        } else {
            $view = $page->getPageTemplate();
        }
        return $view;
    }

    /**
     * @return BasePageRepository
     */
    protected function getPageRepository()
    {
        $em = $this->getDoctrine()->getManager();
        $pageEntity = $this->getParameter('mtt_easy_page.page_entity');
        return $em->getRepository($pageEntity);
    }

}
