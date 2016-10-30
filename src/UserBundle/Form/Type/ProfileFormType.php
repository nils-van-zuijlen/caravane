<?php

namespace UserBundle\Form\Type;

use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ProfileFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add(
				'username',
				null,
				array(
					'label'              => 'form.username',
					'translation_domain' => 'UserBundle',
					)
				)
			->add(
				'email',
				\Symfony\Component\Form\Extension\Core\Type\EmailType::class,
				array(
					'label'              => 'form.email',
					'translation_domain' => 'UserBundle'
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
				'current_password',
				\Symfony\Component\Form\Extension\Core\Type\PasswordType::class,
				array(
					'label'              => 'form.current_password',
					'translation_domain' => 'UserBundle',
					'mapped'             => false,
					'constraints'        => new UserPassword(),
					)
				);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'UserBundle\Entity\User',
			'csrf_token_id' => 'profile',
		));
	}

	public function getBlockPrefix()
	{
		return 'user_profile';
	}
}
