<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EditionType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName',
                    TextType::class,
                    $this->getConfiguration("Nom", "entrez le nom")
                    )
            ->add('lastName',
                    TextType::class,
                    $this->getConfiguration("Prenom", "Prenom")
                )
            ->add('email', 
                    EmailType::class,
                    $this->getConfiguration("Email", "Email")
            )
            ->add('picture',
            UrlType::class,
            $this->getConfiguration("Picture", "Url du picture"))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction", "INtroduction"))
            ->add('description', TextareaType::class, $this->getCOnfiguration("Description", "Desc"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
