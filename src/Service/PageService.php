<?php

namespace Mtt\EasyPageBundle\Service;

use Doctrine\ORM\EntityManager;

use Mtt\EasyPageBundle\Entity\PageEntityInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


/**
 * Class Page
 * @package Mtt\EasyPageBundle\Service
 * TODO test for this service
 */
class PageService
{
    protected $em;

    protected $classEntity;
    protected $router;

    /**
     * Page constructor.
     * @param EntityManager $entityManager
     * @param $classEntity string
     */
    public function __construct(EntityManager $entityManager, $classEntity, \Symfony\Component\Routing\RouterInterface $router)
    {
        $this->em = $entityManager;
        $this->classEntity = $classEntity;
        $this->router = $router;
    }


    /**
     * @param $entity \Mtt\EasyPageBundle\Entity\BasePage
     */
    public function getPageUrl(\Mtt\EasyPageBundle\Entity\PageEntityInterface $entity): string
    {
        return $this->router->generate('easypage_show', array('slug' => $entity->getSlug()), UrlGeneratorInterface::ABSOLUTE_URL);
    }

    public function createPage()
    {
        return new $this->classEntity;
    }


    protected function normalizeSlug(PageEntityInterface $entity)
    {
        if (null === $entity->getSlug()) {
            $entity->setSlug(
                $this->slugger->slugify($entity->getName())
            );
        }
        $normalizedSlug = $this->slugger->slugify($entity->getSlug());
        $entity->setSlug($normalizedSlug);
    }

}