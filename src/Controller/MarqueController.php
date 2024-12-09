<?php

namespace App\Controller;

use App\Form\MarqueType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\MarqueEntity;
use App\Repository\MarqueRepository;
use App\Form\SupprimerMarqueType;


class MarqueController extends AbstractController
{
    #[Route('', name: 'app_marque')]
    public function index(ManagerRegistry $doctrine): Response
    {
        // Récupération des marques depuis le repository
        $repository = $doctrine->getRepository(MarqueEntity::class);
        $marques = $repository->findAll();

        return $this->render('home/index.html.twig', [
            'marques' => $marques, // On passe les marques au template
        ]);
    }
    #[Route('/marque/ajouter', name: 'app_marque_ajout')]
    public function ajouter(Request $request, ManagerRegistry $doctrine): Response
    {
        //Création formulaire
        $marque = new MarqueEntity();
        //Je crée le formulaire
        $form = $this->createForm(MarqueType::class, $marque);

        //Gestion de la requête
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Sauvegarde de la marque
            $em = $doctrine->getManager();
            $em->persist($marque);
            $em->flush();
            //Redirection vers la page d'accueil
            return $this->redirectToRoute('app_marque');
        }
        return $this->render('marque/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);

    }
    #[Route('/marque/modifier/{id}', name: 'app_marque_modifier')]
    public function modifier($id, Request $request, ManagerRegistry $doctrine, MarqueRepository $repo): Response
    {
        //Création formulaire
        //1 je crée une marque avec doctrine
        $marque =$repo->find($id);
        //2 je crée le formulaire
        $form = $this->createForm(MarqueType::class, $marque);

        //3 gestion de la requête
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //4 je sauvegarde la marque
            $em = $doctrine->getManager();
            $em->persist($marque);
            $em->flush();
            //5 je redirige vers la page d'accueil
            return $this->redirectToRoute('app_marque');
        }

        return $this->render('marque/modifier.html.twig', [
            'controller_name' => 'MarqueController',
        ]);
    }
    #[Route('/marque/supprimer/{id}', name: 'app_marque_supprimer')]
    public function supprimer($id, Request $request, ManagerRegistry $doctrine, MarqueRepository $repo): Response
    {
        //Création formulaire
        //1 je crée une marque avec doctrine
        $marque = $repo->find($id);
        //2 je crée le formulaire
        $form = $this->createForm(SupprimerMarqueType::class, $marque);

        //3 gestion de la requête
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //4 je sauvegarde la marque
            $em = $doctrine->getManager();
            $em->remove($marque);
            $em->flush();
            //5 je redirige vers la page d'accueil
            return $this->redirectToRoute('app_marque');

        }
        return $this->render('marque/supprimer.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
