<?php

namespace App\Form;

use App\Entity\Booking;
use App\Form\ApplicationType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Exception\TransformationFailedException;

class BookingType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate',TextType::class, $this->getConfiguration(
                "Date de début",
                "Entrez votre date de début"))
            ->add('endDate',TextType::class, $this->getConfiguration(
                "Date de fin",
                "Entrez votre date de fin"))
        ;
        $builder->get('startDate')
            ->addModelTransformer(new CallbackTransformer(
                function ($date) {
                    if($date === null) {
                        return '';
                    }
                    return $date->format('d/m/Y');
                },
                function ($frenchDate) {
                    if($frenchDate === null) {
                        throw new TransformationFailedException("Vous devez fournir une date");
                    }

                    $date = \DateTime::createFromFormat('d/m/Y',$frenchDate);

                    if($date === false) {
                        throw new TransformationFailedException("Le format n'est pas le bon");
                    }
                    return $date;
                }
            ))
        ;
        $builder->get('endDate')
            ->addModelTransformer(new CallbackTransformer(
                function ($date) {
                    if($date === null) {
                        return '';
                    }
                    return $date->format('d/m/Y');
                },
                function ($frenchDate) {
                    if($frenchDate === null) {
                        throw new TransformationFailedException("Vous devez fournir une date");
                    }

                    $date = \DateTime::createFromFormat('d/m/Y',$frenchDate);

                    if($date === false) {
                        throw new TransformationFailedException("Le format n'est pas le bon");
                    }
                    return $date;
                }
            ))
        ; 
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'csrf_protection' => false
        ]);
    }
}
