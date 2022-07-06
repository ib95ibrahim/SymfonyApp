<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Form\Enseignant1Type;
use App\Repository\EnseignantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/enseignant/crud")
 */
class EnseignantCrudController extends AbstractController
{
    /**
     * @Route("/", name="app_enseignant_crud_index", methods={"GET"})
     */
    public function index(EnseignantRepository $enseignantRepository): Response
    {
        return $this->render('enseignant_crud/index.html.twig', [
            'enseignants' => $enseignantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_enseignant_crud_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EnseignantRepository $enseignantRepository): Response
    {
        $enseignant = new Enseignant();
        $form = $this->createForm(Enseignant1Type::class, $enseignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $enseignantRepository->add($enseignant, true);

            return $this->redirectToRoute('app_enseignant_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('enseignant_crud/new.html.twig', [
            'enseignant' => $enseignant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_enseignant_crud_show", methods={"GET"})
     */
    public function show(Enseignant $enseignant): Response
    {
        return $this->render('enseignant_crud/show.html.twig', [
            'enseignant' => $enseignant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_enseignant_crud_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Enseignant $enseignant, EnseignantRepository $enseignantRepository): Response
    {
        $form = $this->createForm(Enseignant1Type::class, $enseignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $enseignantRepository->add($enseignant, true);

            return $this->redirectToRoute('app_enseignant_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('enseignant_crud/edit.html.twig', [
            'enseignant' => $enseignant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_enseignant_crud_delete")
     */
    public function delete($id, EnseignantRepository $enseignantRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $course = $enseignantRepository->find($id);
        $em->remove($course);
        $em->flush();

        return $this->redirectToRoute('app_enseignant_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
