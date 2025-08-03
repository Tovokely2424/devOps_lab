<?php

namespace App\Form;

use App\Entity\EvaluationScore;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvaluationScoreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('score', IntegerType::class, [
            'label' => false,
            'attr' => ['min' => 1, 'max' => 5],
            'required' => false
        ])
        ->add('commentaire', TextareaType::class, [
            'label' => false,
            'required' => false,
            'attr' => ['rows' => 2]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EvaluationScore::class,
        ]);
    }
}
