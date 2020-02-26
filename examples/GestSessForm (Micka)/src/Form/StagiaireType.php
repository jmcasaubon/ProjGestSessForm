<?php

namespace App\Form;

use App\Entity\Stagiaire;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomStagiaire', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class' => 'uk-input']
            ])
            ->add('prenomStagiaire', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['class' => 'uk-input']
            ])
            ->add('sexeStagiaire', TextType::class, [
                'label' => 'Sexe',
                'attr' => ['class' => 'uk-input']
            ])
            ->add('dateNaissance', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'attr' => ['class' => 'uk-select']
            ])
            ->add('mailStagiaire', EmailType::class, [
                'label' => 'Courriel',
                'attr' => ['class' => 'uk-input']
            ])
            ->add('telStagiaire', TextType::class, [
                'label' => 'Téléphone',
                'attr' => ['class' => 'uk-input']
            ])
            ->add('villeStagiaire', TextType::class, [
                'label' => 'Ville',
                'attr' => ['class' => 'uk-input']
            ])
            ->add('Enregistrer', SubmitType::class, [
                'attr' => ['class' => 'uk-button uk-button-dark mt10']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}
