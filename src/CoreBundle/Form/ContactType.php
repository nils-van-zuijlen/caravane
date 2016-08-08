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
				TextType::class
			)
			->add(
				'prenom', 
				TextType::class
			)
			->add(
				'email', 
				EmailType::class
			)
			->add(
				'objet', 
				TextType::class
			)
			->add(
				'contenu', 
				TextareaType::class
			)
			->add(
				'send', 
				SubmitType::class
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