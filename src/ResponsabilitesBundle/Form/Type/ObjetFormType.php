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
					'label' => 'Nom de l'objet (plusieurs objets peuvent avoir le même nom)',
					)
				)
      ->add(
        'type',
        EntityType::class,
        array(
          'label' => 'Type d'objet',
          'class' => 'ResponsabilitesBundle:TypeObjet',
          'choice_label' => 'nom',
          )
        )
      ->add(
        'commentaires',
        TextareaType::class,
        array(
          'label' => 'Commentaires',
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
					'data_class' => 'ResponsabilitesBundle\Entity\Objet',
					)
				);
	}
}
