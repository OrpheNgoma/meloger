<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Ads;
use App\Form\AdsType;
use App\Entity\Images;
use App\Repository\AdsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/ads")
 */
class AdsController extends AbstractController
{
    public function __construct(FlashyNotifier $flashy)
    {
      $this->flashy = $flashy;
    }

    /**
     * @Route("/", name="ads_index", methods={"GET"})
     */
    public function index(AdsRepository $adsRepository): Response
    {
        return $this->render('ads/index.html.twig', [
            'current_menu' => 'annonce',
            'ads' => $adsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ads_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->getUser();

        $ad = new Ads();
        $ad->setUsers($this->getUser());
        $form = $this->createForm(AdsType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises
            $images = $form->get('images')->getData();

            // On boucle sur les images
            foreach ($images as $image) 
            {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // On stocke le nom de l'image en BDD
                $img = new Images();
                $img->setName($fichier);
                $ad->addImage($img);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ad);
            $entityManager->flush();
            // $flashy->success('Nouvelle annonce créer avec succès !', '');
            return $this->redirectToRoute('ads_index');
        }

        return $this->render('ads/new.html.twig', [
            'ad' => $ad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ads_show", methods={"GET"})
     */
    public function show(Ads $ad): Response
    {
        return $this->render('ads/show.html.twig', [
            'ad' => $ad,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ads_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ads $ad): Response
    {
        $form = $this->createForm(AdsType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $flashy->primaryDark('Annonce modifié avec succès !', '');
            return $this->redirectToRoute('ads_index');
        }

        return $this->render('ads/edit.html.twig', [
            'ad' => $ad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ads_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ads $ad): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ad->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ad);
            $entityManager->flush();
            $flashy->warning('Annonce supprimé avec succès !', '');
        }

        return $this->redirectToRoute('ads_index');
    }
}
