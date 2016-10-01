<?php
namespace ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForumType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
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
				'categorie',
				EntityType::class,
				array(
					'label'        => 'Catégorie',
					'multiple'     => false,
					'expanded'     => false,
					'class'        => 'ForumBundle:Categorie',
					'choice_label' => 'title',
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
					'data_class' => 'ForumBundle\Entity\Forum'
					)
				);
	}
}
