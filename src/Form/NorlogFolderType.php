<?php

namespace App\Form;

use App\Entity\NorlogFolder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NorlogFolderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('norlogReference', TextType::class, [
                'label' => 'Référence du dossier'
            ])
            ->add('skus', CollectionType::class, [
                'entry_type' => SkuType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
	            'prototype' => 'skus'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NorlogFolder::class,
        ]);
    }
}