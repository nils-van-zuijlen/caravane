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
	/**
	 * @var string
	 */
	private $class;

	/**
	 * @param string $class The User class name
	 */
	public function __construct($class)
	{
		$this->class = $class;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add(
				'username',
				null,
				array(
					'label'              => 'form.username',
					'translation_domain' => 'FOSUserBundle',
					)
				)
			->add(
				'email',
				\Symfony\Component\Form\Extension\Core\Type\EmailType::class,
				array(
					'label'              => 'form.email',
					'translation_domain' => 'FOSUserBundle'
					)
				)
			->add(
				'nom',
				null,
				array(
					'label' => 'Nom',
					)
				)
			->add(
				'prenom',
				null,
				array(
					'label' => 'Prénom',
					)
				)
			->add(
				'current_password',
				\Symfony\Component\Form\Extension\Core\Type\PasswordType::class,
				array(
					'label'              => 'form.current_password',
					'translation_domain' => 'FOSUserBundle',
					'mapped'             => false,
					'constraints'        => new UserPassword(),
					)
				);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => $this->class,
			'csrf_token_id' => 'profile',
		));
	}

	public function getBlockPrefix()
	{
		return 'user_profile';
	}
}
