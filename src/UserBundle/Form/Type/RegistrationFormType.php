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

class RegistrationFormType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add(
				'email',
				\Symfony\Component\Form\Extension\Core\Type\EmailType::class,
				array(
					'label'              => 'form.email',
					'translation_domain' => 'UserBundle',
					)
				)
			->add(
				'username',
				null,
				array(
					'label'              => 'form.username',
					'translation_domain' => 'UserBundle',
					)
				)
			->add(
				'nom',
				null,
				array(
					'label'              => 'form.nom',
					'translation_domain' => 'UserBundle',
					)
				)
			->add(
				'prenom',
				null,
				array(
					'label'              => 'form.prenom',
					'translation_domain' => 'UserBundle',
					)
				)
			->add(
				'plainPassword',
				\Symfony\Component\Form\Extension\Core\Type\RepeatedType::class,
				array(
					'type'            => \Symfony\Component\Form\Extension\Core\Type\PasswordType::class,
					'options'         => array('translation_domain' => 'UserBundle'),
					'first_options'   => array('label' => 'form.password'),
					'second_options'  => array('label' => 'form.password_confirmation',),
					'invalid_message' => 'fos_user.password.mismatch',
					)
				);
	}

	public function getBlockPrefix()
	{
		return 'user_registration';
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class'    => 'UserBundle\Entity\User',
			'csrf_token_id' => 'registration',
		));
	}
}
