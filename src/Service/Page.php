<?php

namespace Mtt\EasyPageBundle\Service;

use Doctrine\ORM\EntityManager;
use Mtt\EasyPageBundle\Model\PageEntityInterface;


class Page
{
    protected $em;
    /**
     * @var \Cocur\Slugify\Slugify
     */
    protected $slugger;

    public function __construct(EntityManager $entityManager, \Cocur\Slugify\SlugifyInterface  $slugger)
    {
        $this->em = $entityManager;
        $this->slugger = $slugger;
    }

    /**
     * @param $entity \Mtt\EasyPageBundle\Entity\BasePage
     */
    public function savePage($entity){
        $this->beforeSave($entity);
        $this->em->persist($entity);
        $this->em->flush();
    }


    protected function beforeSave($entity){
        $this->normalizeSlug($entity);
    }

    /**
     * @param $entity \Mtt\EasyPageBundle\Entity\BasePage
     */
    protected function normalizeSlug($entity){
        if(null === $entity->getSlug()){
            $entity->setSlug(
                $this->slugger->slugify($entity->getName())
            );
        }
        $normalizedUrl = $this->slugger->slugify($entity->getSlug());

        $entity->setSlug($normalizedUrl);
    }
}