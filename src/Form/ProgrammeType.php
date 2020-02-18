<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Session;
use App\Entity\Programme;
use Symfony\Component\Form\AbstractType;
use App\Form\DataTransformer\SessionTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProgrammeType extends AbstractType
{
    private $transformer;

    public function __construct(SessionTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('session', HiddenType::class)
            ->add('module',  EntityType::class, [
                'label' => 'Module',
                'class' => Module::class,
                'choice_label' => 'categorieLibelle'
            ])
            ->add('duree',   IntegerType::class, [
                'label' => 'Durée (en jours)',
                'attr' => [ 'min' => '1', 'max' => '50']
            ])
        ;

        $builder
            ->get('session')
            ->addModelTransformer($this->transformer)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Programme::class,
        ]);
    }
}
