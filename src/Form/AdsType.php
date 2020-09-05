<?php

namespace App\Form;

use App\Entity\Ads;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AdsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class)
            ->add('content', CKEditorType::class)
            ->add('images', FileType::class, [
                'label' => false,
                'multiple' => true,
                'required' => false,
                'mapped' => false
            ])
            ->add('address')
            ->add('price')
            ->add('charges', ChoiceType::class,[
                'choices' => $this->getCharges()
            ])
            ->add('releaseDate')
            ->add('status')
            ->add('categories')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ads::class,
            'translation_domain' => 'forms'
        ]);
    }

    private function getCharges()
    {
        $charges = Ads::CHARGES;
        $outpout = [];
        foreach ($charges as $c => $a) {
            $outpout[$a] = $c;
        }
        return $outpout;
    }

    // private function getTitre()
    // {
    //     $titre = Ads::TITRE;
    //     $outpout = [];
    //     foreach ($titre as $t => $n) {
    //         $outpout[$n] = $t;
    //     }
    //     return $outpout;
    // }
}
