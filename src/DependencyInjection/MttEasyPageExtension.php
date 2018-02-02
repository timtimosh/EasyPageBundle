<?php

namespace Mtt\EasyPageBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\Definition\Processor;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class MttEasyPageExtension  extends Extension implements PrependExtensionInterface, CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        //die('2');
    }

    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        $myBundleConfig = $this->processConfiguration(new Configuration(), $configs);

        $container->setParameter('mtt_easy_page.page_entity', $myBundleConfig['page_entity']);
        $container->setParameter('mtt_easy_page.image_entity', $myBundleConfig['image_entity']);
        $container->setParameter('mtt_easy_page.gallery_entity', $myBundleConfig['gallery_entity']);

        if(isset($myBundleConfig['easy_admin_integration'])) {
            $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../EasyAdminIntegration/Resources/config'));
            $loader->load('superadmin.yml');
        }
       // $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
/*
        dump($container->getExtensionConfig('doctrine'));
        $loader->load('doctrine.yml');
        dump($container->getExtensionConfig('doctrine'));
        exit();*/

    }

    /**
     * @param ContainerBuilder $container
     * process() is called after all extensions are loaded
     */
    public function process(ContainerBuilder $container)
    {
        $interfaces = [
            'Mtt\EasyPageBundle\Entity\PageEntityInterface' => $container->getParameter('mtt_easy_page.page_entity')
            ];
        $def = $container->findDefinition('doctrine.orm.listeners.resolve_target_entity');
        foreach ($interfaces as $entityInterface => $resolvedClass){
            $def->addMethodCall('addResolveTargetEntity', array($entityInterface, $resolvedClass, array()));
        }
      /*  $def = $container->findDefinition('doctrine.orm.listeners.resolve_target_entity');
        dump($def);
        die($container->getParameter('mtt_easy_page.page_entity'));*/
    }
}
