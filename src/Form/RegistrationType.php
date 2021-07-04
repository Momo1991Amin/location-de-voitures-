<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends ApplicationType
{
  

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("firstName", TextType::class, $this->getConfiguration(false,'Prénom'))
            ->add("lastName", TextType::class, $this->getConfiguration(false,"Nom"))
            ->add("email", EmailType::class, $this->getConfiguration(false,"Email"))
            ->add("avatar", UrlType::class, $this->getConfiguration(false,"URL image"))
            ->add("hash", PasswordType::class, $this->getConfiguration(false,"Tapez votre mot de passe"))
            ->add("passwordConfirm", PasswordType::class, $this->getConfiguration(false,"Re-tapez votre mot de passe"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
