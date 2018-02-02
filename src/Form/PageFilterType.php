<?php

namespace LittleHouse\EasyPageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;


class PageFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', Filters\NumberFilterType::class)
            ->add('name', Filters\TextFilterType::class)
            ->add('parent', Filters\NumberFilterType::class)
            ->add('active', Filters\BooleanFilterType::class)
            ->add('descriptionShort', Filters\TextFilterType::class)
            ->add('description', Filters\TextFilterType::class)
            ->add('seoTitle', Filters\TextFilterType::class)
            ->add('seoH1', Filters\TextFilterType::class)
            ->add('metaDescription', Filters\TextFilterType::class)
            ->add('metaKeyword', Filters\TextFilterType::class)
            ->add('slug', Filters\TextFilterType::class)
            ->add('listTemplate', Filters\TextFilterType::class)
            ->add('pageTemplate', Filters\TextFilterType::class)
        
        ;
        $builder->setMethod("GET");


    }

    public function getBlockPrefix()
    {
        return null;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'allow_extra_fields' => true,
            'csrf_protection' => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}
