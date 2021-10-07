<?php

namespace App\Form;

use App\Entity\Composition;
use App\Entity\Couleur;
use App\Entity\Designation;
use App\Entity\Etat;
use App\Entity\Marque;
use App\Entity\Sku;
use App\Entity\Taille;
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
                'label'         => 'SKU du produit',
                'help'          => 'La référence du dossier lié sera ajoutée automatiquement au SKU'
            ])
            ->add('marque', EntityType::class, [
	            'class'         => Marque::class,
	            'choice_label'  => 'name',
	            'placeholder' => 'Choisir une option',
	            'mapped'        => true
            ])
	        ->add('taille', EntityType::class, [
		        'class'         => Taille::class,
		        'choice_label'  => 'name',
		        'placeholder' => 'Choisir une option',
		        'mapped'        => true
	        ])
	        ->add('designation', EntityType::class, [
		        'class'         => Designation::class,
		        'choice_label'  => 'name',
		        'placeholder' => 'Choisir une option',
		        'mapped'        => true
	        ])
	        ->add('couleur', EntityType::class, [
		        'class'         => Couleur::class,
		        'choice_label'  => 'name',
		        'placeholder' => 'Choisir une option',
		        'mapped'        => true
	        ])
	        ->add('etat', EntityType::class, [
		        'class'         => Etat::class,
		        'choice_label'  => 'name',
		        'placeholder' => 'Choisir une option',
		        'mapped'        => true
	        ])
	        ->add('composition', EntityType::class, [
		        'class'         => Composition::class,
		        'choice_label'  => 'name',
		        'placeholder' => 'Choisir une option',
		        'mapped'        => true
	        ])
            ->add('picture_1', FileType::class, [
                'label'         => 'Image 1 du produit',
                'mapped'        => false,
                'required'      => false,
                'attr'          => ['accept' => 'image/*']
            ])
            ->add('picture_2', FileType::class, [
                'label'         => 'Image 2 du produit',
                'mapped'        => false,
                'required'      => false,
                'attr'          => ['accept' => 'image/*']
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
