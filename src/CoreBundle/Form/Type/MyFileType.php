<?php
namespace CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MyFileType extends AbstractType
{
	public function buildForm(
		FormBuilderInterface $builder,
		array $options
		)
	{
		$builder
			->add(
				'file',
				FileType::class,
				array(
					'label' => '',
					)
				);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver
			->setDefaults(
				array(
					'data_class' => 'CoreBundle\Entity\File'
					)
				);
	}
}
