<?php
namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use CoreBundle\Form\MyFileType;

class ActusType extends AbstractType
{
	public function buildForm(
		FormBuilderInterface $builder,
		array $options
		)
	{
		$builder
			->add(
				'title',
				TextType::class,
				array(
					'label' => 'Titre',
					)
				)
			->add(
				'content',
				TextareaType::class,
				array(
					'label' => 'Contenu',
					)
				)
			->add(
				'image',
				MyFileType::class,
				array(
					'label' => 'Image',
					)
				)
			->add(
				'submit', 
				SubmitType::class,
				array(
					'label' => 'Publier',
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
					'data_class' => 'CoreBundle\Entity\Actus'
					)
				);
	}
}