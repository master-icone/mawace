<?php

namespace Previsionnel\PrevisionnelBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DepartementsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("nom", "PUGX\AutocompleterBundle\Form\Type\AutocompleteType", [
                "label" => "Nom departement :",
                "attr" => ["placeholder" => "Nom Departement"],
                "class" => "PrevisionnelBundle:Departements",
            ])


            ->add("nouveauNom", TextType::class, [
                "mapped" => false,
                "required" => false,
                "attr" => ["placeholder" => "Nouveau Nom"],
                "label" => "Nouveau nom : "
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
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Previsionnel\PrevisionnelBundle\Entity\Departements'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'previsionnel_previsionnelbundle_departements';
    }


}
