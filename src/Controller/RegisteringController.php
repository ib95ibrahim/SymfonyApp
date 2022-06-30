<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisteringController extends AbstractController
{
    /**
     * @Route("/register", name="app_registering",methods={"GET","POST"})
     */
    public function index(Request $request,UserPasswordHasherInterface $passHasher): Response
    {
        $regform = $this->createFormBuilder()
            ->add('username', TextType::class, [
                'label' => 'Username'
            ])
            ->add('password', null, [
                'required' => true,
            ])
            ->add('Register', SubmitType::class)
            ->getForm();

        $regform->handleRequest($request);

        if($regform->isSubmitted()){
            $input = $regform->getData();
            $user = new User();
            $user->setRoles(['ROLE_USER']);

            $user->setUsername($input['username']);

            $user->setPassword(
                $passHasher->hashPassword($user,$input['password'])
            );
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('registering/index.html.twig', [
            'regform' => $regform->createView(),
        ]);
    }
}
