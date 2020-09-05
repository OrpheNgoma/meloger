<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passEncoder)
    {
        $form = $this->createFormBuilder()
            ->add('username', TextType::class, ['label' => 'Nom d\'utilisateur'])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirme mot de passe'],
                'constraints' => [
                    new NotBlank,
                    new Length (['min' => 6, 'max' => 4096])
                ]
            ])
            // ->add('Enregistrer', SubmitType::class, [
            //     'attr' => [
            //         'class' => 'btn btn-success float-right'
            //     ]
                
            // ])
            ->getForm();

        $form = $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $user = new User();
            $user->setUsername($data['username']);
            $user->setPassword(
                $passEncoder->encodePassword($user, $data['password'])
            );
            $user->setIsActive(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre compte à bien été enregistré !');

            return $this->redirect($this->generateUrl('app_login'));
        }
        
        // if ($form->isSubmitted() && $form->isValid()) { 
            
        // }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'RegisterController',
        ]);
    }
}
