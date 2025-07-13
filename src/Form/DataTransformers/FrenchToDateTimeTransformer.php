<?php
namespace App\Form\DataTransformers;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FrenchToDateTimeTransformer implements DataTransformerInterface{
    public function transform($date)
    {
        if ($date === null) {
            return '';
        }
        return $date->format('d/m/Y');
    }

    public function reverseTransform($frenchDate)
    {
        if ($frenchDate === null) {
            throw new TransformationFailedException('Il faut une date en format d/m/Y');
        }
        $date = \DateTime::createFromFormat('d/m/Y', $frenchDate);
        if ($date === false) {
            throw new TransformationFailedException('La date doit être au format d/m/Y');
        }
        return $date;

    }
}

?>