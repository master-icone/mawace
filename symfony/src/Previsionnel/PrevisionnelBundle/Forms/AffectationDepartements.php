<?php

namespace Previsionnel\PrevisionnelBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AffectationDepartements extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


            ->add("idutilisateur", "PUGX\AutocompleterBundle\Form\Type\AutocompleteType", [
                "class" => "PrevisionnelBundle:Utilisateurs",
                "label" => "Professeur : ",
                "attr" => ["placeholder" => "Professeur"],
            ])


            ->add("departement", "PUGX\AutocompleterBundle\Form\Type\AutocompleteType", [
                "mapped" => false,
                "class" => "PrevisionnelBundle:Departements",
                "attr" => ["placeholder" => "Département"]
            ])




            ->add("affecter", SubmitType::class, [
                "label" => "Affecter",
                "attr" => ["class" => "btn btn-success"],
            ])







            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Previsionnel\PrevisionnelBundle\Entity\Archiveutilisateurs'
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
