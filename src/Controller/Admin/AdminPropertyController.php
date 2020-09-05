<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Option;
use App\Entity\Property;
use App\Form\EditUserType;
use App\Form\PropertyType;
use App\Entity\PropertySearch;
use App\Repository\UserRepository;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
*/

class AdminPropertyController extends AbstractController
{

    public function __construct(PropertyRepository $repository, ObjectManager $em, FlashyNotifier $flashy)
    {
      $this->repository = $repository;
      $this->em = $em;
      $this->flashy = $flashy;
    }

    /**
     * @Route("/", name="property_index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
            $search = new PropertySearch();


            $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('admin/property/index.html.twig', [
            'current_menu' => 'gestbien',
            'properties'   => $properties
        ]);
    }

    /**
     * @Route("/admin/property/create", name="property_new")
     *
     * @return void
     * @param Option $option
     */
    public function new(Request $request): Response
    {
        $this->getUser();

        $property = new Property();
        $property->setOwner($this->getUser());
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            $flashy->success('Nouveau bien créer avec succès!', '');
            return $this->redirectToRoute('property_index');
        }
        return $this->render('admin/property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="property_edit", methods="GET|POST")
     * @param Request $request
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Property $property, Request $request)
    {

        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $this->em->flush();
            $flashy->primaryDark('Bien modifié avec succès!', '');
            return $this->redirectToRoute('property_index');
        }
        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="property_delete", methods="DELETE")
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Property $property, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {
            $this->em->remove($property);
            $this->em->flush();
            $flashy->warning('Bien supprimé avec succès!', '');
        }
        return $this->redirectToRoute( 'property_index');
    }

    /**
     * @Route("/utilisateurs", name="app_users")
     */
    public function usersList(UserRepository $user) {
        return $this->render("admin/user/index.html.twig",[
            'current_menu' => 'gestuser',
            'users' => $user->findAll()
        ]);
    }

     /**
     * @Route("/admin/user/{id}", name="user_edit", methods="GET|POST")
     */
    public function editUser(Request $request, User $user, ObjectManager  $em, FlashyNotifier $flashy) {
       
        $form = $this->createForm(EditUserType::class,$user);
  
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
          $em->flush();
          $flashy->primaryDark('Utilisateur modifié avec succès!', '');
          return $this->redirectToRoute('app_users');
        }
  
        return $this->render('admin/user/edit.html.twig', ['formUser' => $form->createView()]);
      }
}
