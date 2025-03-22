<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    class HomeController extends AbstractController{
        /**
         * @Route("/", name="homepage")
         */
        public function home(){
            $prenom = ["Tovo"=>28, "Helisoa"=>30, "Mathis"=>1];
            return $this -> render(
            'home.html.twig',
            ['title'=> "Pi Aceuil",
            'h1' => "Premiere page reussi",
            'age' => 14,
            'tableau'=>$prenom
            ]
        );
        }
    }




?>