<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\Course1Type;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/course/crud")
 */
class CourseCrudController extends AbstractController
{
    /**
     * @Route("/", name="app_course_crud_index", methods={"GET"})
     */
    public function index(CourseRepository $courseRepository): Response
    {
        return $this->render('course_crud/index.html.twig', [
            'courses' => $courseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_course_crud_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CourseRepository $courseRepository): Response
    {
        $course = new Course();
        $form = $this->createForm(Course1Type::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseRepository->add($course, true);

            return $this->redirectToRoute('app_course_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('course_crud/new.html.twig', [
            'course' => $course,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_course_crud_show", methods={"GET"})
     */
    public function show(Course $course): Response
    {
        return $this->render('course_crud/show.html.twig', [
            'course' => $course,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_course_crud_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Course $course, CourseRepository $courseRepository): Response
    {
        $form = $this->createForm(Course1Type::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseRepository->add($course, true);

            return $this->redirectToRoute('app_course_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('course_crud/edit.html.twig', [
            'course' => $course,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_course_crud_delete")
     */
    public function delete($id , CourseRepository $courseRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $course = $courseRepository->find($id);
        $em->remove($course);
        $em->flush();

        return $this->redirectToRoute('app_course_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
