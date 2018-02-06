<?php

namespace Mtt\EasyPageBundle\EasyAdminIntegration\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;


class PageController extends BaseAdminController
{

    public function createNewPageEntity(){
        return $this->getPageService()->createPage();
    }

    public function persistPageEntity($page)
    {
        $this->getPageService()->updatePage($page, false);
        parent::persistPageEntity($page);
    }

    /**
     * @param $entity \Mtt\EasyPageBundle\Entity\BasePage
     * @inheritdoc
     */
    protected function createPagesEntityForm($entity, $entityProperties, $view)
    {
        $formBuilder = $this->executeDynamicMethod('create<EntityName>EntityFormBuilder', array($entity, $view));
        $smallImage = $this->getMainImagePath($entity);
       /* $formBuilder->add('mainImage', 'Sonata\MediaBundle\Form\Type\MediaType', array(
            'provider' => "sonata.media.provider.image",
            'context' => "default",
           // 'help' => '' !== $smallImage ? "<img src='" . $smallImage . "' alt='" . $entity->getName() . "'>" : ''
        ));*/

   /*     $formBuilder->add('images', 'sonata_type_model_list',
            array(
                'required' => false
            )
        );*/
        return $formBuilder->getForm();
    }



    /**
     * @return \Mtt\EasyPageBundle\Service\Page
     */

    protected function getPageService(){
        return $this->get('mtt_easypage.page.service');
    }

}
