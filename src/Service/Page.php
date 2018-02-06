<?php

namespace Mtt\EasyPageBundle\Service;

use Doctrine\ORM\EntityManager;
use Mtt\EasyPageBundle\Model\PageEntityInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Page
{
    protected $em;
    /**
     * @var \Cocur\Slugify\Slugify
     */
    protected $slugger;
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected $router;

    public function __construct(EntityManager $entityManager, \Cocur\Slugify\SlugifyInterface $slugger, \Symfony\Component\Routing\RouterInterface $routerSerivce)
    {
        $this->em = $entityManager;
        $this->slugger = $slugger;
        $this->router = $routerSerivce;
    }

    /**
     * @param $entity \Mtt\EasyPageBundle\Entity\BasePage
     */
    public function getEntitySlug($entity):string{
        return $this->router->generate('easypage_show', array('slug' => $entity->getSlug()), UrlGeneratorInterface::ABSOLUTE_URL);
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