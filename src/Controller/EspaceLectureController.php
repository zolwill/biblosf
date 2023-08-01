<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Proxies\__CG__\App\Entity\Livre;
use App\Entity\Emprunt;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/espace-lecture" , name:"app_espace_lecture") ]
class EspaceLectureController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function index(): Response
    {
        return $this->render('espace_lecture/index.html.twig', [
            'controller_name' => 'EspaceLectureController',
        ]);
    }
    #[Route('/emprunter-livre-{id}', name: '_emprunter', requirements: ["id" => "\d+"], methods:["GET"])]
    public function emprunter(Livre $livre, EntityManagerInterface $em)
    {
        $emprunt = new Emprunt;
        $emprunt->getLivre($livre);
        $emprunt->setAbonne($this->getUser());
        $emprunt->setDateEmprunt(new \DateTime());

        $em->persist($emprunt);
        $em->flush();
        $this->addFlash("sucess" , "message");
        return $this->redirectToRoute("app_espace_lecture_index");
    }
}
