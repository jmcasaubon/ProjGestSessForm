<?php
//
// Forumlaire permettant d'ajouter / de modifier les informations personnelles d'un stagiaire.
//

namespace App\Form;

use App\Entity\Stagiaire;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CodePostalVilleListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents::PRE_SUBMIT   => 'onPreSubmit',
        ];
    }

    public function onPreSetData(FormEvent $event)
    {
        $data = $event->getData() ;
        $form = $event->getForm() ;

        $ville = $data->getVille();

        $form->add('ville', ChoiceType::class, [
            'choices' => [$ville => $ville],
            'attr' => [ 'class' => 'choix-ville' ],
        ]);
    }

    public function onPreSubmit(FormEvent $event)
    {
        $input = $event->getData()['ville'] ;
        $event->getForm()->add('ville', ChoiceType::class, [
            'choices' => [$input]
        ]);
    }
}

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
                'widget' => 'single_text'
            ])
            ->add('adresse',        TextType::class, [
                'label' => 'Adresse (N°, voie et complément)',
                'required' => false
            ])
            ->add('cpostal',        TextType::class, [
                'label' => 'Code Postal',
                'attr' => [ 'class' => 'code-postal' ],
                'required' => false
            ])
            ->add('ville',          ChoiceType::class, [
                'label' => 'Ville',
                'attr' => [ 'class' => 'choix-ville' ],
                'required' => false
            ])
            ->addEventSubscriber(new CodePostalVilleListener())
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
