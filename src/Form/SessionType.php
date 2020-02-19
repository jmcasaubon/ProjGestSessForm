<?php

namespace App\Form;

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
        $builder
            ->add('intitule',       TextType::class, [
                'label' => 'Intitulé de la session'
            ])
            ->add('dateDebut',      DateType::class, [
                'label' => 'Date de démarrage',
                'format' => 'd/M/y'
            ])
            ->add('dateFin',        DateType::class, [
                'label' => 'Date d\'achèvement',
                'format' => 'd/M/y'
            ])
            ->add('nbPlaces',       IntegerType::class, [
                'label' => 'Nombre de places',
                'attr' => [ 'min' => '1', 'max' => '25']
            ])
            ->add('programmes',     CollectionType::class, [
                'entry_type' => ProgrammeType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ])
            ->add('Enregistrer',    SubmitType::class, [
                'attr' => [ 'class' => 'button' ]
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
