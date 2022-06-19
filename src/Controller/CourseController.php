<?php

namespace App\Controller;

use App\Entity\Course;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
    /**
     * @Route("/course", name="app_course")
     */
    public function index(): Response
    {
        return $this->render('course/index.html.twig', [
            'controller_name' => 'CourseController',
        ]);
    }
    /**
     * @Route("/course", name="app_course")
     */
    public function courses(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $courses = $em->getRepository(Course::class)->findAll();

        return $this->render('course/index.html.twig', [
            'courses' => $courses,
        ]);
    }
}
