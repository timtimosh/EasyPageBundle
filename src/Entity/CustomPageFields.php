<?php
declare(strict_types=1);

namespace Mtt\EasyPageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity()
 * @ORM\Table(name="mtt_easypages_custom_fields")
 */
class CustomPageFields
{
    const APPLY_FOR_CHILDREN = 0;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $type;

    /**
     * @var string
     * @ORM\Column(type="string", length=65535, nullable=false)
     */
    protected $content;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $applyForChildren = self::APPLY_FOR_CHILDREN;


    public function getId():?int
    {
        return $this->id;
    }


    public function getType():?string
    {
        return $this->type;
    }


    public function setType(?string $type)
    {
        $this->type = $type;
    }


    public function getContent()
    {
        return $this->content;
    }


    public function setContent($content)
    {
        $this->content = $content;
    }


    public function getApplyForChildren():bool
    {
        return $this->applyForChildren ? true: false;
    }


    public function setApplyForChildren(bool $applyForChildren)
    {
        $this->applyForChildren = $applyForChildren;
    }



}

