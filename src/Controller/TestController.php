<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
/*     Dans symfony, les méthodes d'un controller DOIVENT retouner un objet de la response
c'est un commentaire. en php 8, le #[] va etre utilisé pour les attributs PHP8*/
    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
      /*   la méthode 'render permet de généerer l'affichage html.
        1er argument : nom du fichier vue qui sera utilisé
        2ème argument : tableau associatif contenant les variables à transmettre au
        template twig (ici, on envoie le controller name)
         */
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
  
    #[Route("/test/nouvelle-route")]
    public function nouvelleRoute()
    {
        return $this->render("base.html.twig");
    }

#[Route("/test/salut")]
public function salut()
{
    return $this->render("test/salut.html.twig",
    ['prenom' => "Lamine"]);
}



#[Route("/test/calcul")]
public function calcul(){
    $a = 12;
    $b=5;
    $resultat = $a * $b ;
    return $this->render("test/calcul.html.twig",["n1" => $a , "n2" => $b , "nresultat"=> $resultat]);
}

#[Route("/test/tableau", name: "app_test_tableau")]
public function tableau()
{
    $t = ["bonjours" , "j'ai" , 30 ,"ans" , false];
    return $this->render("test/tableau.html.twig",
    ['tab' => $t]);
}
// pour que un url soit dynamique il lui ajouter de {} et le mettre en parametre au niveau de la fonction 
// le requirement est utiliser avec les expression reguliere et sert a limiter l'ecriture dans 'lurl
#[Route("/test/carres/{longueur}" , name:"app_test_carres" , requirements:["longueur" => "[0-9]+"])]
public function carre($longueur)
{ 
    return $this->render("test/carres.html.twig" , ["longueur" => $longueur]);
}

#[Route("/test/carres/{longueur}" , name:"app_test_carres2")] 
public function carre2($longueur){   
    return $this->render('test/index.html.twig',['controller_name' => $longueur , "toto" => 5,"titi" => "du texte"]);
}
// si il y a un ? dans l'url alors il est optionnel
#[Route("/test/salut/{nom}/{prenom?}" , name:"app_test_salut")]
public function salutation($nom,$prenom){
    $personne["nom"]=$nom;
    $personne['prenom'] =$prenom;
    return $this->render("test/personne.html.twig", ["personne"=> $personne]);
}

#[Route("/test/salut/{nom}/{prenom?}" , name:"app_test_salut2")]
public function salutations($nom,$prenom){
    $personne = new \stdClass;
    $personne->nom=$nom;
    $personne->prenom = $prenom;
    return $this->render("test/personne.html.twig", ["personne"=> $personne]);
}

#[Route("/test/exo/{nombre1}/{nombre2}" )]
public function nombre($nombre1 , $nombre2){
    return $this->render("test/exo.html.twig", ["nombre1"=>$nombre1,"nombre2"=>$nombre2]);
}
}