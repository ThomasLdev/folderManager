<?php

namespace App\Form;

use App\Entity\NorlogFolder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NorlogFolderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('norlogReference', TextType::class)
            ->add('sku', SkuType::class)
        ;
    }
}