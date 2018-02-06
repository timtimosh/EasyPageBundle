<?php

namespace Mtt\EasyPageBundle\Repository;

use Doctrine\ORM\EntityRepository;
use \Mtt\EasyPageBundle\Entity\BasePage as BasePageEntity;

class BasePageRepository extends EntityRepository
{
    public function findAllActive()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM ' . $this->_entityName . ' as p
                WHERE p.active = ' . BasePageEntity::ACTIVE . ' '
            );
    }


}