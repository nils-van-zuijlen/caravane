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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RoleFormType extends AbstractType
{
	private $class;

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add(
				'name',
				ChoiceType::class,
				array(
					'label' => 'Rôles',
					'expanded' => true,
					'multiple' => true,
					'choices' => array(
						'Hiérarchie' => array(
							'PioK' => 'ROLE_PIOK',
							'Chef' => 'ROLE_CHEF',
							),
						'Responsabilité' => array(
							'Responsable Communication'   => 'ROLE_COMMUNICATION',
							'Responsable Intendance'      => 'ROLE_INTENDANCE',
							'Responsable Vie Spirituelle' => 'ROLE_VIE_SPI',
							'Responsable Animation'       => 'ROLE_ANIMATION',
							'Responsable Budget'          => 'ROLE_BUDGET',
							'Responsable Matériel'        => 'ROLE_MATERIEL',
							'Responsable Hébergement'     => 'ROLE_HEBERGEMENT',
							'Responsable Santé'           => 'ROLE_SANTE',
							),
						),
					)
				);
	}

	public function configureOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(
			array(
				'data_class' => 'UserBundle\Entity\User',
				)
			);
	}

	public function getBlockPrefix()
	{
		return 'fos_user_group';
	}
}
