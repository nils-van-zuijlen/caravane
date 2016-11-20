<?php
namespace ForumBundle\Form\Type;

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
					'label'              => 'forum.form.title',
					'translation_domain' => 'ForumBundle',
					)
				)
			->add(
				'content',
				TextareaType::class,
				array(
					'label'              => 'forum.form.content',
					'translation_domain' => 'ForumBundle',
					)
				)
			->add(
				'categorie',
				EntityType::class,
				array(
					'label'              => 'forum.form.categorie',
					'translation_domain' => 'ForumBundle',
					'multiple'           => false,
					'expanded'           => false,
					'class'              => 'ForumBundle:Categorie',
					'choice_label'       => 'title',
					)
				)
			->add(
				'submit',
				SubmitType::class,
				array(
					'label'              => 'forum.form.submit',
					'translation_domain' => 'ForumBundle',
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
					'data_class' => 'ForumBundle\Entity\Forum'
					)
				);
	}
}
