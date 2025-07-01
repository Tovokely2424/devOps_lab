<?php

namespace App\Form;

use App\Entity\Booking;
use PharIo\Manifest\Application;

use App\Form\ApplicationType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate',
            DateType::class, 
            $this->getConfiguration("Date de début", "La date à laquelle vous souhaitez commencer votre réservation",
            ['widget' => 'single_text', 'html5' => true]
            ))
            ->add('endDate', 
            DateType::class,
            $this->getConfiguration("Date de fin", "La date à laquelle vous souhaitez terminer votre réservation",
            [
                'widget' => 'single_text', 
                'html5' => true
                ]
            ))
            ->add('comment',
            TextareaType::class,
            $this->getConfiguration("Commentaire", "Si vous avez des questions, n'hésitez pas à les poser ici",
            ['required' => false, 'attr' => ['rows' => 5]])
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
