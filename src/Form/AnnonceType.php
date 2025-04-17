<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AnnonceType extends AbstractType
{

    private function getConfiguration($title, $placeholder="", $options = []){
        return array_merge([
            'label' => $title,
            'attr' => [
                'placeholder' => $placeholder,
            ]
        
        ], $options);
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tittle', 
                TextType::class, 
                $this->getConfiguration("Titre de l'annonce", "Entrez le titre de votre annonce")
            )
            ->add('slug', 
                TextType::class, 
                $this->getConfiguration("Adresse web", "Entrez ici votre adresse web (automatique)", ['required'=>false] )
            )
            ->add('price', 
                MoneyType::class, 
                $this->getConfiguration("Prix par nuit", "Entrez le prix par nuité")
            )
            ->add('introduction', 
                TextType::class, 
                $this->getConfiguration("Introduction", "Entrez l'introduction de votre annonce")
            )
            ->add('content', 
                TextareaType::class, 
                $this->getConfiguration("Description de l'annonce", "Entrez la description précise de votre annonce")
            )
            ->add('converImage', 
                UrlType::class, 
                $this->getConfiguration("Url de l'image", "Entrer l'url de l'emplacement de l'image")
            )
            ->add('rooms', 
                IntegerType::class, 
                $this->getConfiguration("Nombre de chambre", "Entrez le nombre de chambre")
            )
            ->add('images',
                CollectionType::class,
                [
                    'entry_type' => ImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true
                ]
            )
            ->add('save', 
                SubmitType::class, 
                $this->getConfiguration("Enregistrer l'annonce", "btn btn-primary w-25")
            )
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
