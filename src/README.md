#Here we go..Basic configuration 
##you also may need to pay tour attention on ckeeditor bundle and how to install it

##app/config/routing.yml:

```
mtt_easy_page_bundle:
    resource: "@MttEasyPageBundle/Resources/config/routing.yml"
    prefix:   /pages

_liip_imagine:
    resource: "@LiipImagineBundle/Resources/config/routing.xml"
```
##app/config/services.yml example:

```
   mtt_easypage.slugger.service:
        class: Mtt\EasyPageBundle\Service\Slugger
        arguments:
            - '@cocur_slugify'
            - '@router.default'

   mtt_easypage.page.service:
        class: Mtt\EasyPageBundle\Service\Page
        arguments:
            - '@doctrine.orm.entity_manager'
            - '@mtt_easypage.slugger.service'
            - '%mtt_easy_page.page_entity%'
        public: true

```


##app/config/config.yml example:
 
```
twig:
    globals:
        easypage_service: "@mtt_easypage.page.service"
    paths:
         '%kernel.project_dir%/vendor/mtt/easy-page-bundle/src/Resources/views': easypage_templates

mtt_easy_page:
    page_entity: YOURNAMESPACE\EasyPageBundle\Entity\Page
    easy_admin_integration: true

ivory_ck_editor:
    configs:
        my_config:
            toolbar: full

vich_uploader:
    db_driver: orm # or mongodb or propel or phpcr
    mappings:
        mtt_easypage_image:
            uri_prefix: '%app.path.easypage_images%'
            upload_destination: '%kernel.project_dir%/web/uploads/images/mtt_easypage'
        mtt_catalog_product_image:
            uri_prefix: /uploads/images/mtt_catalog/product
            upload_destination: '%kernel.project_dir%/web/uploads/images/mtt_catalog_product'

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


#AppKernel:
        ``` 
        $bundles[] = new Mtt\EasyPageBundle\MttEasyPageBundle();
        $bundles[] = new Cocur\Slugify\Bridge\Symfony\CocurSlugifyBundle();
        $bundles[] = new Vich\UploaderBundle\VichUploaderBundle();
        $bundles[] = new Liip\ImagineBundle\LiipImagineBundle();
        $bundles[] = new YOURNAMESPACE\EasyPageBundle\YOURNAMESPACEEasyPageBundle();
        ```