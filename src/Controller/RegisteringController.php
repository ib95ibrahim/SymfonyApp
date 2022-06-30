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
     * @Route("/register", name="app_registering")
     */
    public function index(Request $request,UserPasswordHasherInterface $passHasher): Response
    {
        $regform = $this->createFormBuilder()
            ->add('username', TextType::class, [
                'label' => 'Username'
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
            ])

            ->add('Register', SubmitType::class)
            ->getForm();
        $regform->handleRequest($request);

        if($regform->isSubmitted()){
            $input = $regform->getData();

            $user = new User();

            $user->setUsername($input['username']);

            $user->setPassword(
                $passHasher->hashPassword($user,$input['password'])
            );
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirect($this->generateUrl('app_home'));
        }

        return $this->render('registering/index.html.twig', [
            'regform' => $regform->createView(),
        ]);
    }
}
