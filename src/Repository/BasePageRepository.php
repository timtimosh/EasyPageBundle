<?php

namespace Tymosh\EasyPageBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use \Tymosh\EasyPageBundle\Entity\BasePage as BasePageEntity;
use Tymosh\EasyPageBundle\Entity\PageEntityInterface;

class BasePageRepository extends EntityRepository
{
    public function findActive($limit = 0)
    {
        $qb = $this->createPageQuery();
        $this->activeQuery($qb);

        if ($limit) {
            $qb->setMaxResults($limit);
        }
        return $qb->getQuery();
    }

    public function findOneActiveBySlug(string $slug): ?PageEntityInterface
    {
        $qb = $this->createPageQuery();
        $this->activeQuery($qb);

        $qb->andWhere('p.slug = :slug');
        $qb->setParameter('slug', $slug);
        $qb->setMaxResults(1);
        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param $qb QueryBuilder
     */
    protected function activeQuery($qb)
    {
        $qb->where('p.active = :active');
        // ->andWhere('f.end <= :end')
        $qb->setParameter('active', BasePageEntity::ACTIVE);
    }

    protected function createPageQuery()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('p')
            ->from($this->_entityName, 'p');
        return $qb;
    }
}