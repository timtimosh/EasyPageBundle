<?php

namespace Tymosh\EasyPageBundle\Listeners\Doctrine;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Tymosh\EasyPageBundle\Entity\BasePage;
use Tymosh\EasyPageBundle\Entity\PageEntityInterface;


class PageListener
{
    protected $slugger;

    public function __construct(\Cocur\Slugify\SlugifyInterface $cocurSlugify)
    {
        $this->slugger = $cocurSlugify;
    }

    public function prePersist(PageEntityInterface $entity, LifecycleEventArgs $event)
    {
        $entity->updatedTimestamps();
        $this->normalizeSlug($entity);
    }

    /**
     * @param BasePage $entity
     */
    public function preUpdate(PageEntityInterface $entity, PreUpdateEventArgs $event)
    {
        $entity->updatedTimestamps();
        if ($event->hasChangedField('slug')) {
            $this->normalizeSlug($entity);
        }
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