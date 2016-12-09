<?php

namespace Previsionnel\PrevisionnelBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class Recherche extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
            ->add("nom", TextType::class, [
				"label" => "Nom Professeur",
                "required" => false,
			])
			->add("Rechercher", SubmitType::class, [
				"label" => "Rechercher",
			])
			;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Previsionnel\PrevisionnelBundle\Entity\Utilisateurs'
		));
	}
}