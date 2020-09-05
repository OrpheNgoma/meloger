<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\PropertySearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maxPrice', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Budget maximale'
                ]
            ])

            ->add('minSurface', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Surface minimale'
                ]
            ])

            ->add('options', EntityType::class, [
                'required' => false,
                'label' => false,
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true,
                'attr' => [
                    'placeholder' => 'Options'
                ]
            ])
            ->add('address', null, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Quartier'
                ]
            ])
            ->add('distance', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'choices' => [
                    '10 km' => 10,
                    '30 km' => 30,
                    '60 km' => 60,
                    '80 km' => 80,
                    '100 km' => 100,
                    '1000 km' => 1000
                ]
            ])
            ->add('lat', HiddenType::class)
            ->add('lng', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
