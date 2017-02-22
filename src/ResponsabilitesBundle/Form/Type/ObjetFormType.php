<?php

namespace ResponsabilitesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ObjetFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add(
				'nom',
				TextType::class,
				array(
					'label'              => 'form.objet.nom',
					'translation_domain' => 'ResponsabilitesBundle',
					)
				)
			->add(
				'type',
				EntityType::class,
				array(
					'label'              => 'form.objet.type',
					'translation_domain' => 'ResponsabilitesBundle',
					'class'              => 'ResponsabilitesBundle:TypeObjet',
					'choice_label'       => 'nom',
					)
				)
			->add(
				'caracteristiques',
				TextareaType::class,
				array(
					'label'              => 'form.objet.commentaires',
					'translation_domain' => 'ResponsabilitesBundle',
					)
				)
			->add(
				'submit', 
				SubmitType::class,
				array(
					'label'              => 'form.objet.submit',
					'translation_domain' => 'ResponsabilitesBundle',
					'attr'               => array(
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
					'data_class' => 'ResponsabilitesBundle\Entity\Objet',
					)
				);
	}
}
