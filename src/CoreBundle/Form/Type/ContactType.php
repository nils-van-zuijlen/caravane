<?php
namespace CoreBundle\Form\Type;

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
					'label' => 'index.contact.form.nom',
					)
			)
			->add(
				'prenom', 
				TextType::class,
				array(
					'label' => 'index.contact.form.prenom',
					)
			)
			->add(
				'email',
				EmailType::class,
				array(
					'label' => 'index.contact.form.email',
					)
			)
			->add(
				'subject',
				TextType::class,
				array(
					'label' => 'index.contact.form.objet',
					)
			)
			->add(
				'body',
				TextareaType::class,
				array(
					'label' => 'index.contact.form.contenu',
					)
			)
			->add(
				'send',
				SubmitType::class,
				array(
					'label' => 'index.contact.form.send',
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
					'data_class' => 'CoreBundle\FMailer\ContactEmail',
					)
				);
	}
}
