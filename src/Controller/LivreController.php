<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LivreController extends AbstractController
{
    #[Route('/livre', name:'app_livre')]
    public function index(LivreRepository $livreRepository): Response
    {
        $livre = $livreRepository->findAll();
        return $this->render('livre/index.html.twig', [
           "liste_livres" => $livre,
        ]);
    }


    #[Route('/livre/ajouter', name:'app_livre_ajouter')]
    public function ajouter(Request $request, EntityManagerInterface $em): Response
    {
        if( $request->isMethod("POST") ){
            $titre = $request->request->get("titre");
            // on récupère la valeur "titre" dans $_POST. Cela revient à accéder à la propriété 'request'
            // de l'objet $request
            $resume = $request->request->get("resume");

            $livre = new Livre;
            $livre->setTitre($titre);
            $livre->setResume($resume);

            $em->persist($livre);
            $em->flush();
            $this->addFlash("sucess","le nouveau livre a bien été enregistré");
            return $this->redirectToRoute("app_livre");
        }
        return $this->render('livre/formulaire.html.twig');
    }
    #[Route('/livre/modifier/{id}', name:'app_livre_modifier' , requirements: ['id' => "\d+"])]
    public function modifier(LivreRepository $livreRepository , int $id , Request $rq, EntityManagerInterface $em ): Response
    {
        $livre = $livreRepository->find($id);
        if ($rq->isMethod("POST")) {
            $livre->setTitre($rq->request->get("titre"));
            $livre->setResume($rq->request->get("resume"));

            $em->persist($livre);
            $em->flush();
            $this->addFlash("success", "le livre n'$id a bien était modifié");
            return $this->redirecttoRoute("app_livre");
        }
        return $this->render('livre/formulaire.html.twig', [
           "livre" => $livre,
        ]);
    }

    #[ROUTE("/livre/supprimer/{id}" , name: "app_livre_supprimer" , requirements: ['id' => "\d+"])]
    public function supprimer(LivreRepository $lr, int $id , EntityManagerInterface $em , Request $rq){
        $livre = $lr->find($id);
        if ($rq->isMethod("POST")) {

            $em->remove($livre);
            $em->flush();
            $this->addFlash("success", "$id  le livre a bien ete supprimer");
            return $this->redirecttoRoute("app_livre");
        }
        return $this->render("livre/confirmation_suppression.html.twig", ["livre" => $livre ]);
    }
}