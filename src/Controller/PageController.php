<?php

namespace Tymosh\EasyPageBundle\Controller;

use Tymosh\EasyPageBundle\Repository\BasePageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tymosh\EasyPageBundle\Entity\PageEntityInterface;
use \Knp\Component\Pager\PaginatorInterface;


class PageController extends Controller
{
    protected $paginator;
    protected $pageRepository;

    public function __construct(PaginatorInterface $paginator, BasePageRepository $pageRepository)
    {
        $this->paginator = $paginator;
        $this->pageRepository = $pageRepository;
    }

    /**
     * Lists all Page entities.
     */
    public function listAction(Request $request)
    {
        $pagination = $this->paginator->paginate(
            $this->pageRepository->findActive(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $this->getLimit()/*limit per page*/
        );

        // parameters to template
        return $this->render('@easypage_templates/list.html.twig',
            array('pagination' => $pagination)
        );
    }

    /**
     * Finds and displays Page entity.
     */
    public function showAction(string $slug)
    {
        $page = $this->pageRepository->findOneActiveBySlug($slug);
        if (!$page) {
            throw $this->createNotFoundException('The page does not exist');
        }
        $view = $this->getSinglePageTemplate($page);
        return $this->render($view, array(
            'page' => $page,
        ));
    }

    protected function getSinglePageTemplate(PageEntityInterface $page): string
    {
        if (null === $page->getPageTemplate() || '' === $page->getPageTemplate()) {
            return '@easypage_templates/show.html.twig';
        } else {
            return $page->getPageTemplate();
        }
    }

    protected function getLimit()
    {
        return 10;
    }
}
