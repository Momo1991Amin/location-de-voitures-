<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\Category;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CarType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration(false,"Modèle"))
            ->add('price', NumberType::class, $this->getConfiguration(false, "Prix journalier"))
            ->add('content', TextareaType::class, $this->getConfiguration(false,"La description du véhicule"))
            ->add('category', EntityType::class,[
                "class" => Category::class,
                "choice_label" => "name"
                ])
            ->add('image', FileType::class,[
                "label" => false,
                "mapped" => false, 
                "multiple" => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
