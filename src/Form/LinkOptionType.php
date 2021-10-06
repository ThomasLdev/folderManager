<?php

namespace App\Form;

use App\Entity\Option;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LinkOptionType extends \Symfony\Component\Form\AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('value', EntityType::class);
		$builder->add('type');
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Option::class,
		]);
	}
}