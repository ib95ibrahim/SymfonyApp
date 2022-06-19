<?php

namespace App\Controller;
use App\Entity\Enseignant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnseignantController extends AbstractController
{
    /**
     * @Route("/enseignant", name="app_enseignant")
     */
    public function index(): Response
    {

        $em = $this->getDoctrine()->getManager();
        $enseignants = $em->getRepository(Enseignant::class)->findAll();

        return $this->render('enseignant/index.html.twig', [
            'enseignants' => $enseignants,
        ]);
    }
}
