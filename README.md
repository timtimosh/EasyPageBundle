## Info
There is no admin dashboard for this bundle. It has intergration with EasyAdminBundle from the box, or you can integrate it with any other by yourself. There is no edit or new route from box, only the entity with listener and service for using slug etc.

## Install
Here we go.. install it via composer...

Create a PageBundle and PageEntity inside, example: 


```
<?php
namespace PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tymosh\EasyPageBundle\Entity\BasePage;

/**
 * @ORM\Table(name="tymosh_easypage_page", uniqueConstraints={@ORM\UniqueConstraint(name="idx_UNIQUE_slug", columns={"slug"})})
 * @ORM\Entity(repositoryClass="Tymosh\EasyPageBundle\Repository\BasePageRepository")
 * @ORM\EntityListeners({"Tymosh\EasyPageBundle\Listeners\Doctrine\PageListener"})
 */
class Page extends BasePage
{


}
```

**run**: bin/console doctrine:schema:update --force

## Basic configuration 

### app/config/routing.yml:

```
tymosh_easy_page_bundle:
    resource: "@TymoshEasyPageBundle/Resources/config/routing.yml"
    prefix:   /pages

_liip_imagine:
    resource: "@LiipImagineBundle/Resources/config/routing.xml"
```


### app/config/config.yml:
 
```
parameters:
    app.path.easypage_images: '/uploads/images/tymosh_easypage'
    
twig:
    globals:
        easypage_service: "@tymosh_easypage.page.service"
    paths:
         '%kernel.project_dir%/vendor/tymosh/easy-page-bundle/src/Resources/views': easypage_templates

tymosh_easy_page:
    page_entity: YourBundle\Entity\Page
    easy_admin_integration: true

vich_uploader:
    db_driver: orm # or mongodb or propel or phpcr
    mappings:
        tymosh_easypage_image:
            uri_prefix: '%app.path.easypage_images%'
            upload_destination: '%kernel.project_dir%/web/uploads/images/Tymosh_easypage'
        
knp_paginator:
    page_range: 5                       # number of links showed in the pagination menu (e.g: you have 10 pages, a page_range of 3, on the 5th page you'll see links to page 4, 5, 6)
    template:
        pagination: 'pagination/sliding.html.twig'     # sliding pagination controls template
        sortable: 'pagination/sortable_link.html.twig' # sort link template
        filtration: 'pagination/filtration.html.twig'  # filters template

liip_imagine:
    filter_sets:
        cache: ~
        easypage_list_thumb:
            quality: 75
            filters:
                thumbnail: { size: [120, 90], mode: outbound }

        easypage_show_thumb:
            quality: 75
            filters:
                thumbnail: { size: [300, 250], mode: outbound }
```

## AppKernel:
        ``` 
        $bundles[] = new Tymosh\EasyPageBundle\TymoshEasyPageBundle();
        
        $bundles[] = new Cocur\Slugify\Bridge\Symfony\CocurSlugifyBundle();
        
        $bundles[] = new Vich\UploaderBundle\VichUploaderBundle();
        
        $bundles[] = new Liip\ImagineBundle\LiipImagineBundle();
        
        $bundles[] = new YourBundle\PageBundle();
        ```
## Wysiwyg configuring
Pay your attention on ckeeditor bundle https://packagist.org/packages/egeloen/ckeditor-bundle and how to install it. It will be installed by easypage composer require. But it needs additional work to configure it properly, such as installing assets and configuring wysiwyg panel for your needs.
