<?php
namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ChefsEmailFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add(
				'toUsers',
				EntityType::class,
				array(
					'label'        => 'chefs.send_email.form.to.users',
					'required'     => false,
					'class'        => 'UserBundle:User',
					'choice_label' => 'display',
					'multiple'     => true,
					)
				)
			->add(
				'toGroups',
				EntityType::class,
				array(
					'label'        => 'chefs.send_email.form.to.groups',
					'required'     => false,
					'class'        => 'UserBundle:Group',
					'choice_label' => 'name',
					'multiple'     => true,
					)
				)
			->add(
				'isBcc',
				ChoiceType::class,
				array(
					'label'   => 'chefs.send_email.form.is_bcc.label',
					'choices' => array(
						'chefs.send_email.form.is_bcc.true'  => true,
						'chefs.send_email.form.is_bcc.false' => false,
						),
					)
				)
			->add(
				'subject',
				TextType::class,
				array(
					'label' => 'chefs.send_email.form.subject',
					)
				)
			->add(
				'body',
				TextareaType::class,
				array(
					'label' => 'chefs.send_email.form.body',
					)
				)
			->add(
				'submit', 
				SubmitType::class,
				array(
					'label' => 'chefs.send_email.form.submit',
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
					'data_class' => 'CoreBundle\Mailer\ChefsEmail',
					)
				);
	}
}
