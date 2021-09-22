<?php

namespace App\Form;

use App\Entity\NorlogFolder;
use App\Entity\Sku;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class NorlogFolderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('norlogReference', TextType::class)
            ->add('skus', EntityType::class, [
                'class' => Sku::class,
                'multiple' => true
            ]);
    }
}