<?php
namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class EventType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add(
				'dateDebut',
				DateTimeType::class,
				array(
					'label' => 'event.form.date.debut',
					)
				)
			->add(
				'dateFin',
				DateTimeType::class,
				array(
					'label' => 'event.form.date.fin',
					)
				)
			->add(
				'title',
				TextType::class,
				array(
					'label' => 'event.form.title',
					)
				)
			->add(
				'content',
				TextareaType::class,
				array(
					'required' => false,
					'label'    => 'event.form.content',
					)
				)
			->add(
				'submit', 
				SubmitType::class,
				array(
					'label' => 'event.form.submit',
					'attr' => array(
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
					'data_class' => 'CoreBundle\Entity\Event'
					)
				);
	}
}
