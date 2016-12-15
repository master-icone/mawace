<?php

namespace Previsionnel\PrevisionnelBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class Coefficients extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("idtypecours", "PUGX\AutocompleterBundle\Form\Type\AutocompleteType", [
                "class" => "PrevisionnelBundle:Typecours",
                "label" => "Type de cours : ",
                "attr" => ["placeholder" => "Type de cours"],
            ])
            ->add("idstatut", "PUGX\AutocompleterBundle\Form\Type\AutocompleteType", [
                "class" => "PrevisionnelBundle:Statut",
                "label" => "Statut : ",
                "attr" => ["placeholder" => "Statut"],
            ])
            ->add("coeff", NumberType::class, [
                "label" => "Coefficient : ",
                "mapped" => false,
                "attr" => ["placeholder" => "Coefficient"],
            ])
            ->add("coefficienttype",ChoiceType::class, [
                "choices" => [
                "Normal" => "1",
                "Supplémentaire" => "2"],
                "mapped" => false,
                "choices_as_values" => true,
                "multiple" => false,
                "expanded" => true,
                "label" => "Type d'heures : ",
                "attr" => ["placeholder" => "Type d'heures"],
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
                "attr" => ["class" => "btn btn-danger"],
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Previsionnel\PrevisionnelBundle\Entity\Coefficientsnormaux'
        ));
    }
}