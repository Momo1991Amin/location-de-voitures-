<?php

namespace App\Form;

use App\Entity\Category;
use App\Data\SearchCarData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class SearchCarType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('car', TextType::class,[
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' =>'Rechercher un véhicule'
                ]
            ])
            ->add('category', EntityType::class, [
                'label'    => false,
                'required' => false,
                'class'    => Category::class,
                'expanded' => true,
                'multiple' => true,
                'attr'     =>[
                    'class' => 'filter'
                ]
            ])
            ->add('min', NumberType::class, [
                'required'=> false,
                'label'   => false,
                'attr'    => [
                    'placeholder' => 'Prix min' 
                ]
            ])
            ->add('max', NumberType::class, [
                'required'=> false,
                'label'   => false,
                'attr'    => [
                    'placeholder' => 'Prix max' 
                ]
            ]);    
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchCarData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
