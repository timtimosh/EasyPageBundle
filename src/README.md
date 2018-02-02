Here we go..
services.yml:

   mtt_easypage.page.service:
          class: Mtt\EasyPageBundle\Service\Page
          arguments:
              - '@doctrine.orm.entity_manager'
              - '@cocur_slugify'
        
 config.yml:
 
    # Twig Configuration
    twig:
        ...
        paths:
            '%kernel.project_dir%/vendor/mtt/easy-page-bundle/src/Resources/views': easypage_templates    
        
        

  mtt_easy_page:
      page_entity: LittleHouse\EasyPageBundle\Entity\Page
      easy_admin_integration: true #if you need easyadmin integration
      
  mtt_easy_page_bundle:
      resource: "@MttEasyPageBundle/Resources/config/routing.yml"
      prefix:   /pages          