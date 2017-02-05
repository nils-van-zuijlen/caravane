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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RoleFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add(
				'roles',
				ChoiceType::class,
				array(
					'label'                     => 'form.roles.label',
					'translation_domain'        => 'UserBundle',
					'choice_translation_domain' => true,
					'choice_label'              => function($val,$key,$index) {
						return 'role.view.roles.'.$val;
					},
					'expanded'                  => true,
					'multiple'                  => true,
					'choices'                   => array(
						'form.roles.choices.main'     => array(
							'ROLE_PIOK',
							'ROLE_CHEF',
							),
						'form.roles.choices.responsable' => array(
							'ROLE_COMMUNICATION',
							'ROLE_INTENDANCE',
							'ROLE_VIE_SPI',
							'ROLE_ANIMATION',
							'ROLE_BUDGET',
							'ROLE_MATERIEL',
							'ROLE_HEBERGEMENT',
							'ROLE_SANTE',
							),
						'form.roles.choices.special'         => array(
							'ROLE_ADMIN',
							'ROLE_SUPER_ADMIN',
							),
						),
					)
				)
			->add(
				'submit',
				SubmitType::class,
				array(
					'label'              => 'role.edit.submit',
					'translation_domain' => 'UserBundle',
					'attr'               => array(
						'class' => 'btn btn-danger',
						),
					)
				);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(
			array(
				'data_class' => 'UserBundle\Entity\User',
				)
			);
	}
}
