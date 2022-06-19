<?php

namespace App\Controller;

use App\Entity\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(): Response
    {
        $admin = new Admin();
        $admin->setAdminName("administrator");
        $em = $this->getDoctrine()->getManager();
        $adminResult = $em->getRepository(admin::class)->findOneBy([
            'id'=> 1
        ]);
        //$em->remove($adminResult);
        //$em->flush();
        //$em->persist($admin);
        //$em->flush();

       return $this->render('admin/index.html.twig', [
            'admins' => $adminResult,
        ]);
        //return new Response($adminResult);
    }
}
