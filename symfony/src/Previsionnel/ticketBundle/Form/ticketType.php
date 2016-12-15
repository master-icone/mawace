<?php

namespace Previsionnel\ticketBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ticketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
		->add('motif',TextType::class,["attr" => ["placeholder" => "motif"]])
		->add('message',TextareaType::class,["attr" => ["placeholder" => "message"]])
		->add('date',DateType::class)
		->add('etat',TextType::class)
		->add('IdExpediteur',TextType::class)
		->add('idUE',"PUGX\AutocompleterBundle\Form\Type\AutocompleteType", [
            "class" => "mawaceticketBundle:ticket",
            "label" => "UE : ",
            "mapped" => false,
            "attr" => ["placeholder" => "UE"]]);


    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Previsionnel\ticketBundle\Entity\ticket'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mawace_ticketbundle_ticket';
    }


}
