<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Option;
use App\Entity\Property;
use App\Entity\Condition;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', CKEditorType::class)
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            // ->add('cold', ChoiceType::class, [
            //     'choices' => $this->getChoices()
            // ])
            ->add('options', EntityType::class, [
                'class' => Option::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => true
            ])
            ->add('pictureFiles', FileType::class, [
                'required' => true,
                'multiple' => true
            ])
            ->add('city')
            ->add('address')
            ->add('lat', HiddenType::class)
            ->add('lng', HiddenType::class)
            ->add('sold')
            ->add('charge',ChoiceType::class,[
                'choices' => $this->getCharges()
            ])
            ->add('category')
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => true
            ])
            ->add('conditions', EntityType::class, [
                'class' => Condition::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => true
            ])
            // ->add('release_date', DateType::class, ['label' => 'Date de sortie'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms'
        ]);
    }

    // private function getChoices()
    // {
    //     $choices = Property::COLD;
    //     $outpout = [];
    //     foreach ($choices as $k => $v) {
    //         $outpout[$v] = $k;
    //     }
    //     return $outpout;
    // }

    private function getCharges()
    {
        $charges = Property::CHARGE;
        $outpout = [];
        foreach ($charges as $c => $h) {
            $outpout[$h] = $c;
        }
        return $outpout;
    }
}
