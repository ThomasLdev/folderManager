<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Sku;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('SKU', TextType::class, [
                'label' => 'SKU du produit',
                'help' => 'La référence du dossier lié sera ajoutée automatiquement au SKU'
            ])
            ->add('options', CollectionType::class, [
                'entry_type' => OptionType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('picture_1', FileType::class, [
                'label' => 'Image 1 du produit',
                'mapped' => false,
                'required' => false,
                'attr' => ['accept' => 'image/*']
            ])
            ->add('picture_2', FileType::class, [
                'label' => 'Image 2 du produit',
                'mapped' => false,
                'required' => false,
                'attr' => ['accept' => 'image/*']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sku::class,
        ]);
    }
}
