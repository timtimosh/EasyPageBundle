<?php

namespace Mtt\EasyPageBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use \Mtt\EasyPageBundle\Entity\BasePage as BasePageEntity;

class BasePageRepository extends EntityRepository
{
    public function findActive($limit = 0, $execute = false)
    {
        $qb = $this->createPageQuery();
        $this->activeQuery($qb);

        if($limit){
            $qb->setMaxResults($limit);
        }
        if($execute){
            return $qb->getQuery()->execute();
        }
        return $qb->getQuery();
    }

    public function findOneActiveBySlug($slug){

        $qb = $this->createPageQuery();
        $this->activeQuery($qb);

        $qb->andWhere('p.slug = :slug');
        $qb->setParameter('slug', $slug);

        $qb->setMaxResults(1);

        $result = $qb->getQuery()->getOneOrNullResult();
        return $result;
    }

    /**
     * @param $qb QueryBuilder
     */
    protected function activeQuery($qb){
        $qb->where('p.active = :active');
        // ->andWhere('f.end <= :end')
        $qb->setParameter('active', BasePageEntity::ACTIVE);
    }

    protected function createPageQuery(){
        $qb = $this->_em->createQueryBuilder();
        $qb->select('p')
            ->from($this->_entityName, 'p');
        return $qb;
    }
}