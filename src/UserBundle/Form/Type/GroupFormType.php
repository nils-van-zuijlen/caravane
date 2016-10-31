<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class GroupFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add(
				'name',
				TextType::class,
				array(
					'label'              => 'form.group_name',
					'translation_domain' => 'UserBundle'
					)
				)
			->add(
				'users',
				EntityType::class,
				array(
					'class'              => 'UserBundle:User',
					'choice_label'       => 'display',
					'multiple'           => true,
					'label'              => 'form.members',
					'translation_domain' => 'UserBundle',
					#'expanded'          => true,
					'required'           => false,
					)
				);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'UserBundle\Entity\Group',
		));
	}

	public function getBlockPrefix()
	{
		return 'user_group';
	}
}
