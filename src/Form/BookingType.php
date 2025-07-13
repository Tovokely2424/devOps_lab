<?php

namespace App\Form;

use App\Entity\Booking;
use PharIo\Manifest\Application;

use App\Form\ApplicationType;
use App\Form\DataTransformers\FrenchToDateTimeTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends ApplicationType
{
    private $transformer;
    public function __construct(FrenchToDateTimeTransformer $tranformer)
    {
        $this->transformer = $tranformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate',
            TextType::class, 
            $this->getConfiguration("Date de début", "La date à laquelle vous souhaitez commencer votre réservation",
            ))
            ->add('endDate', 
            TextType::class,
            $this->getConfiguration("Date de fin", "La date à laquelle vous souhaitez terminer votre réservation",
            ))
            ->add('comment',
            TextareaType::class,
            $this->getConfiguration("Commentaire", "Si vous avez des questions, n'hésitez pas à les poser ici",
            ['required' => false, 'attr' => ['rows' => 5]])
            )
        ;
        $builder->get('startDate')->addModelTransformer($this->transformer);
        $builder->get('endDate')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
