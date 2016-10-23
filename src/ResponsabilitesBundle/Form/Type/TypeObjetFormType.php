<?php

namespace ResponsabilitesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TypeObjetFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add(
				'nom',
				TextType::class,
				array(
					'label' => 'Nom',
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
					'data_class' => 'ResponsabilitesBundle\Entity\TypeObjet',
					)
				);
	}
}
