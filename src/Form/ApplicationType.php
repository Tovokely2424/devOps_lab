<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType
{
    /**
     * Permet de structurer lea attributs de chaque champs
     */
    protected function getConfiguration($title, $placeholder="", $options = []) : array
    {
        return array_merge([
            'label' => $title,
            'attr' => [
                'placeholder' => $placeholder,
            ]
        
        ], $options);
    }
}


?>