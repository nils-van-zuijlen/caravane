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
					'label'              => 'form.extra_job.equipe',
					'translation_domain' => 'ResponsabilitesBundle',
					'required'           => true,
					'class'              => 'UserBundle:Group',
					'choice_label'       => 'name',
					)
				)
			->add(
				'date',
				DateType::class,
				array(
					'label'              => 'form.extra_job.date',
					'translation_domain' => 'ResponsabilitesBundle',
					)
				)
			->add(
				'montant',
				NumberType::class,
				array(
					'label'              => 'form.extra_job.montant',
					'translation_domain' => 'ResponsabilitesBundle',
					'scale'              => 2,
					'rounding_mode'      => IntegerToLocalizedStringTransformer::ROUND_HALF_DOWN,
					'attr'               => array(
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
					'label'              => 'form.extra_job.commentaires',
					'translation_domain' => 'ResponsabilitesBundle',
					'required'           => false,
					)
				)
			->add(
				'submit', 
				SubmitType::class,
				array(
					'label'              => 'form.extra_job.submit',
					'translation_domain' => 'ResponsabilitesBundle',
					'attr'               => array(
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
