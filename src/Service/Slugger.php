<?php

namespace Mtt\EasyPageBundle\Service;


class Slugger
{
    /**
     * @var \Cocur\Slugify\Slugify
     */
    protected $slugger;
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected $router;


    public function __construct(\Cocur\Slugify\SlugifyInterface $slugger, \Symfony\Component\Routing\RouterInterface $routerSerivce)
    {
        $this->slugger = $slugger;
        $this->router = $routerSerivce;
    }

    /**
     * @param $entity \Mtt\EasyPageBundle\Entity\BasePage
     */
    public function getLink(\Mtt\EasyPageBundle\Entity\PageEntityInterface $entity):string{
        return $this->router->generate('easypage_show', array('slug' => $entity->getSlug()), UrlGeneratorInterface::ABSOLUTE_URL);
    }

    public function slugify(string $slug):string {
        return $this->slugger->slugify($slug);
    }
}