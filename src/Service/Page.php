<?php

namespace Mtt\EasyPageBundle\Service;

use Doctrine\ORM\EntityManager;

use Mtt\EasyPageBundle\Entity\PageEntityInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Mtt\EasyPageBundle\Service\PageInterface as PageServiceInterface;

/**
 * Class Page
 * @package Mtt\EasyPageBundle\Service
 * TODO test for this service
 */
class Page implements PageServiceInterface
{
    protected $em;

    protected $slugger;

    protected $classEntity;

    /**
     * Page constructor.
     * @param EntityManager $entityManager
     * @param $slugger \Mtt\EasyPageBundle\Service\Slugger
     * @param $classEntity string
     */
    public function __construct(EntityManager $entityManager, $slugger, $classEntity)
    {
        $this->em = $entityManager;
        $this->slugger = $slugger;
        $this->classEntity = $classEntity;
    }

    /**
     * @param $entity \Mtt\EasyPageBundle\Entity\BasePage
     */
    public function getPageUrl(\Mtt\EasyPageBundle\Entity\PageEntityInterface $entity): string
    {
        return $this->slugger->slugify($entity->getSlug());
    }

    /**
     * @param $entity \Mtt\EasyPageBundle\Entity\BasePage
     */
    public function updatePage($entity, $flush = true)
    {
        $this->beforeUpdate($entity);
        $this->em->persist($entity);
        if ($flush) {
            $this->em->flush();
        }
        $this->afterUpdate($entity);
    }

    /**
     * @param $entity \Mtt\EasyPageBundle\Entity\BasePage
     */
    public function savePage($entity, $flush = true)
    {
        $this->updatePage($entity, $flush);
    }

    /**
     * @param $entity \Mtt\EasyPageBundle\Entity\BasePage
     */
    public function deletePage($entity)
    {
        $this->em->remove($entity);
        $this->flush();
    }

    public function createPage()
    {
        return new $this->classEntity;
    }

    protected function beforeUpdate($entity)
    {
        $this->normalizeSlug($entity);
    }

    protected function afterUpdate($entity)
    {
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