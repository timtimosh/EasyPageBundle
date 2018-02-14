<?php

namespace Mtt\EasyPageBundle\Entity;

use Doctrine\Common\Collections\Collection;

interface PageEntityInterface
{
    public function getChilds():?Collection;

}

