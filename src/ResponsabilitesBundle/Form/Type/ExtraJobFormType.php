<?php

namespace ResponsabilitesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\DataTransformer\IntegerToLocalizedStringTransformer;

class ExtraJobFormType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add(
				'equipe',
				EntityType::class,
				array(
					'label'        => 'Équipe',
					'required'     => true,
					'class'        => 'UserBundle:Group',
					'choice_label' => 'name',
					)
				)
			->add(
				'date',
				DateType::class,
				array(
					'label' => 'Date de l\'extra job',
					)
				)
			->add(
				'montant',
				NumberType::class,
				array(
					'label'         => 'Montant gagné (en €)',
					'scale'         => 2,
					'rounding_mode' => IntegerToLocalizedStringTransformer::ROUND_HALF_DOWN,
					'attr'          => array(
						'min'  => 0.01,
						'max'  => 99999999.99,
						'step' => 0.01,
						),
					)
				)
			->add(
				'commentaires',
				TextareaType::class,
				array(
					'label'    => 'Commentaires',
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
				)
		;
	}
	
	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'ResponsabilitesBundle\Entity\ExtraJob'
		));
	}
}
