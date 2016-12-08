<?php

namespace Previsionnel\PrevisionnelBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class Prevision extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add("idutilisateur", "PUGX\AutocompleterBundle\Form\Type\AutocompleteType", [
				"class" => "PrevisionnelBundle:Utilisateurs",
				"label" => "Professeur : ",
				"attr" => ["placeholder" => "Professeur"],
			])
			->add("ue", "PUGX\AutocompleterBundle\Form\Type\AutocompleteType", [
				"class" => "PrevisionnelBundle:Ue",
				"label" => "UE : ",
				"mapped" => false,
				"attr" => ["placeholder" => "UE"],
			])
			->add("typecours", "PUGX\AutocompleterBundle\Form\Type\AutocompleteType", [
				"class" => "PrevisionnelBundle:Typecours",
				"label" => "Type de cours : ",
				"mapped" => false,
				"attr" => ["placeholder" => "Type de cours"],
			])
			->add("nbheures", NumberType::class, [
				"label" => "Nombre d'heures : ",
				"attr" => ["placeholder" => "Nombre d'heures"],
				"data" => "0",
			])
			->add("ajouter", SubmitType::class, [
				"label" => "Ajouter",
                "attr" => ["class" => "btn btn-success pull-left"],
			])
			->add("modifier", SubmitType::class, [
                "label" => "Modifier",
                "attr" => ["class" => "btn btn-warning pull-left"],
			])
			->add("supprimer", SubmitType::class, [
                "label" => "Supprimer",
                "attr" => ["class" => "btn btn-danger pull-left"],
			])
			;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Previsionnel\PrevisionnelBundle\Entity\Heuresaffectees'
		));
	}
}