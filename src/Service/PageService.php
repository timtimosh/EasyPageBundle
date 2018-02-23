<?php

namespace Mtt\EasyPageBundle\Service;


use Mtt\EasyPageBundle\Entity\PageEntityInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;



class PageService
{
    protected $classEntity;
    protected $router;


    public function __construct(string $classEntity, \Symfony\Component\Routing\RouterInterface $router)
    {
        $this->classEntity = $classEntity;
        $this->router = $router;
    }



    public function getPageUrl(PageEntityInterface $entity): string
    {
        return $this->router->generate('easypage_show', array('slug' => $entity->getSlug()), UrlGeneratorInterface::ABSOLUTE_URL);
    }

    public function createPage()
    {
        return new $this->classEntity;
    }

}