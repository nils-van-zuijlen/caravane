<?php

namespace ResponsabilitesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class MenuFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add(
				'titre',
				TextType::class,
				array(
					'label' => 'Nom du menu',
					)
				)
			->add(
				'date',
				DateTimeType::class,
				array(
					'label' => 'Date et heure',
					)
				)
			->add(
				'entree',
				TextareaType::class,
				array(
					'label'    => 'Entrée',
					'required' => false,
					)
				)
			->add(
				'plat',
				TextareaType::class,
				array(
					'label'    => 'Plat',
					'required' => false,
					)
				)
			->add(
				'dessert',
				TextareaType::class,
				array(
					'label'    => 'Dessert',
					'required' => false,
					)
				)
			->add(
				'submit', 
				SubmitType::class,
				array(
					'label' => 'Enregistrer',
					'attr'  => array(
						'class' => 'btn btn-primary',
						),
					)
				);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver
			->setDefaults(
				array(
					'data_class' => 'ResponsabilitesBundle\Entity\Menu',
					)
				);
	}
}
