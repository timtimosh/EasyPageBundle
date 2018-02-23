<?php

namespace Tymosh\EasyPageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 *
 * @ORM\MappedSuperclass
 * @Vich\Uploadable
 */

abstract class BasePage implements PageEntityInterface
{

    const ACTIVE = 1;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;



    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    protected $active = self::ACTIVE;


    /**
     * @var string
     *
     * @ORM\Column(name="description_short", type="text", length=255, nullable=true)
     */
    protected $descriptionShort;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_title", type="string", length=255, nullable=true)
     */
    protected $seoTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_h1", type="string", length=255, nullable=true)
     */
    protected $seoH1;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="string", length=255, nullable=true)
     */
    protected $metaDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_keyword", type="string", length=255, nullable=true)
     */
    protected $metaKeyword;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="template_for_list", type="string", length=255, nullable=true)
     */
    protected $listTemplate;

    /**
     * @var string
     *
     * @ORM\Column(name="page_template", type="string", length=255, nullable=true)
     */
    protected $pageTemplate;



    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    protected $updatedAt;


    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    protected $mainImage;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * @Vich\UploadableField(mapping="tymosh_easypage_image", fileNameProperty="mainImage")
     * @var File
     */
    protected $mainImageFile;

    /**
     * One Page has One parent Page.
     * @ORM\ManyToOne(targetEntity="Tymosh\EasyPageBundle\Entity\PageEntityInterface", inversedBy="childs")
     */
    protected $parent;

    /**
     * One Page has One parent Page.
     * @ORM\OneToMany(targetEntity="Tymosh\EasyPageBundle\Entity\PageEntityInterface", mappedBy="parent", fetch="EXTRA_LAZY")
     */
    protected $childs;

    /**
     * One Page may have many custom fields
     * @ORM\ManyToMany(targetEntity="Tymosh\EasyPageBundle\Entity\CustomPageFields", fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="tymosh_easypages_pages_to_custom_fields")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $customFields;

    /**
     * @return mixed
     */
    public function getCustomFields():?Collection
    {
        return $this->customFields;
    }

    /**
     * @param mixed $customFields
     */
    public function setCustomFields(array $customFields)
    {
        $this->customFields->clear();
        foreach ($customFields as $customField){
            $this->customFields->add($customField);
        }
    }


    public function __construct()
    {
        $this->childs = new ArrayCollection();
        $this->customFields = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getChilds():?Collection
    {
        return $this->childs;
    }

    /**
     * @param mixed $childs
     */
    public function setChilds(array $childs)
    {
        foreach ($childs as $child){
            $this->addChild($child);
        }
    }

    public function addChild(PageEntityInterface $child){
        $this->childs->add($child);
    }


    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile $image
     */
    public function setMainImageFile(?File $image = null)
    {
        $this->mainImageFile = $image;
        if (null !== $image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedTimestamps();
        }
    }

    public function getMainImageFile()
    {
        return $this->mainImageFile;
    }

    public function setMainImage($image)
    {
        $this->mainImage= $image;
    }

    public function getMainImage()
    {
        return $this->mainImage;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getListTemplate()
    {
        return $this->listTemplate;
    }

    /**
     * @param string $listTemplate
     */
    public function setListTemplate($listTemplate)
    {
        $this->listTemplate = $listTemplate;
    }

    /**
     * @return string
     */
    public function getPageTemplate()
    {
        return $this->pageTemplate;
    }

    /**
     * @param string $pageTemplate
     */
    public function setPageTemplate($pageTemplate)
    {
        $this->pageTemplate = $pageTemplate;
    }



    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return PageEntityInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param $parent PageEntityInterface
     */
    public function setParent(PageEntityInterface $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return bool
     */
    public function isActive():bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive($active):bool
    {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getDescriptionShort()
    {
        return $this->descriptionShort;
    }

    /**
     * @param string $descriptionShort
     */
    public function setDescriptionShort($descriptionShort)
    {
        $this->descriptionShort = $descriptionShort;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getSeoTitle()
    {
        return $this->seoTitle;
    }

    /**
     * @param string $seoTitle
     */
    public function setSeoTitle($seoTitle)
    {
        $this->seoTitle = $seoTitle;
    }

    /**
     * @return string
     */
    public function getSeoH1()
    {
        return $this->seoH1;
    }

    /**
     * @param string $seoH1
     */
    public function setSeoH1($seoH1)
    {
        $this->seoH1 = $seoH1;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * @param string $metaDescription
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;
    }

    /**
     * @return string
     */
    public function getMetaKeyword()
    {
        return $this->metaKeyword;
    }

    /**
     * @param string $metaKeyword
     */
    public function setMetaKeyword($metaKeyword)
    {
        $this->metaKeyword = $metaKeyword;
    }


    public function updatedTimestamps()
    {
        $this->updatedAt = new \DateTime('now');
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTime('now');
        }
    }


    public function __toString()
    {
        return $this->getName();
    }
}

