<?php

namespace App\Form;

use App\Entity\Evaluation;
use App\Entity\Critere;
use App\Entity\EvaluationScore;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EvaluationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // ✅ Basic fields for Evaluation
        $builder
            ->add('commentaireGlobal', TextareaType::class, [
                'required' => false,
                'label' => 'Commentaire général'
            ])
            ->add('noteTotale', null, [
                'required' => false,
                'label' => 'Note totale'
            ]);

        // ✅ Add event listener to dynamically build criteria scores
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            /** @var Evaluation|null $evaluation */
            $evaluation = $event->getData();
            $form = $event->getForm();

            if (!$evaluation || null === $evaluation->getId()) {
                // If this is a new Evaluation, you might need to load criteres manually here
                return;
            }

            // ✅ Dynamically add fields for each existing score
            foreach ($evaluation->getScores() as $score) {
                $critere = $score->getCritere();
                $form->add('critere_'.$critere->getId(), ChoiceType::class, [
                    'label' => $critere->getTitre(),
                    'choices' => [
                        '1' => 1,
                        '2' => 2,
                        '3' => 3,
                        '4' => 4,
                        '5' => 5,
                        'N/A' => null,
                    ],
                    'data' => $score->getValeur(), // pre-fill existing value
                    'mapped' => false, // handle saving manually
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evaluation::class,
        ]);
    }
}
