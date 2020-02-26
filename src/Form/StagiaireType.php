<?php
//
// Forumlaire permettant d'ajouter / de modifier les informations personnelles d'un stagiaire.
//

namespace App\Form;

use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',            TextType::class, [
                'label' => 'Nom'
            ])
            ->add('prenom',         TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('sexe',           ChoiceType::class, [
                'label' => 'Genre',
                'choices' => [ 'Masculin' => 'M', 'Féminin' => 'F', 'Non spécifié' => '-' ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('dateNaissance',  BirthdayType::class, [
                'label' => 'Date de Naissance',
                'format' => 'd/M/y'
            ])
            ->add('adresse',        TextType::class, [
                'label' => 'Adresse (N°, voie et complément)',
                'required' => false
            ])
            ->add('cpostal',        TextType::class, [
                'label' => 'Code Postal',
                'required' => false
            ])
            ->add('ville',          TextType::class, [
                'label' => 'Ville',
                'required' => false
            ])
            ->add('telephone',      TextType::class, [
                'label' => 'Téléphone (fixe ou mobile)',
                'required' => false
            ])
            ->add('mail',           EmailType::class, [
                'label' => 'Adresse de messagerie'
            ])
            ->add('Enregistrer',    SubmitType::class, [
                'attr' => [ 'class' => 'button big' ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}
