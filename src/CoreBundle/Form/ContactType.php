<?php
namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
	public function buildForm(
		FormBuilderInterface $builder,
		array $options
		)
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
				'prenom', 
				TextType::class,
				array(
					'label' => 'Prénom',
					)
			)
			->add(
				'email', 
				EmailType::class,
				array(
					'label' => 'E-mail',
					)
			)
			->add(
				'objet', 
				TextType::class,
				array(
					'label' => 'Objet',
					)
			)
			->add(
				'contenu', 
				TextareaType::class,
				array(
					'label' => 'Contenu',
					)
			)
			->add(
				'send', 
				SubmitType::class,
				array(
					'label' => 'Envoyer',
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
					'data_class' => 'CoreBundle\FormModels\ContactModel'
					)
				);
	}
}