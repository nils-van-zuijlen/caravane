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

use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ChangePasswordFormType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add(
				'current_password',
				\Symfony\Component\Form\Extension\Core\Type\PasswordType::class,
				array(
					'label'              => 'form.current_password',
					'translation_domain' => 'UserBundle',
					'mapped'             => false,
					'constraints'        => new UserPassword(!empty($options['validation_groups']) ? array('groups' => array(reset($options['validation_groups']))) : null),
					)
				)
			->add(
				'plainPassword',
				\Symfony\Component\Form\Extension\Core\Type\RepeatedType::class,
				array(
					'type'            => \Symfony\Component\Form\Extension\Core\Type\PasswordType::class,
					'options'         => array('translation_domain' => 'UserBundle'),
					'first_options'   => array('label' => 'form.new_password'),
					'second_options'  => array('label' => 'form.new_password_confirmation'),
					'invalid_message' => 'fos_user.password.mismatch',
					)
				);
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class'    => 'UserBundle\Entity\User',
			'csrf_token_id' => 'change_password',
		));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix()
	{
		return 'user_change_password';
	}
}
