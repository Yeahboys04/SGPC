<?php

namespace App\Form;

use App\Entity\Status;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, 
                ['label' => 'Login'])
            ->add('fullname', TextType::class, 
                ['label' => 'Nom et Prénom'])
            ->add('mail', EmailType::class, 
                ['label' => 'Email'])
            ->add('password', PasswordType::class, 
                ['label' => 'Mot de passe'])
            ->add('endrightdate', DateType::class, 
                ['label' => 'Date de fin de droit',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'html5' => false,
                'required'   => false])
            ->add('idStatus', EntityType::class, 
                ['class' => Status::class,
                'label' => 'Statut'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
