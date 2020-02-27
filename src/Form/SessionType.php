<?php
//
// Formulaire permettant d'ajouter / de modifier une session, ainsi que son programme (<=> ses modules avec leur durée).
//
// Ce formulaire intègre le sous-formulaire "Programme", intégré à chaque fois que nécessaire via le script jQuery "gsf.js". 
//
// Ce formulaire et tous les sous-formulaires sont validés simultanément.
//

namespace App\Form;

use DateTime;
use App\Entity\Session;
use App\Form\ProgrammeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $now = new DateTime ;
        
        $builder
            ->add('intitule',       TextType::class, [
                'label' => 'Intitulé de la session'
            ])
            ->add('dateDebut',      DateType::class, [
                'label' => 'Date de démarrage',
                'widget' => 'single_text'
            ])
            ->add('dateFin',        DateType::class, [
                'label' => 'Date d\'achèvement',
                'widget' => 'single_text'
            ])
            ->add('nbPlaces',       IntegerType::class, [
                'label' => 'Nombre de places',
                'attr' => [ 'min' => '1', 'max' => '25']
            ])
            ->add('programmes',     CollectionType::class, [
                'entry_type' => ProgrammeType::class,
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ])
            ->add('Enregistrer',    SubmitType::class, [
                'attr' => [ 'class' => 'button big' ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
