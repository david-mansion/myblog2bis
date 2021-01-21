<?php

namespace App\Controller;

use App\Entity\Categories; // DM_ ENTITY pour pouvoir utiliser la Classe Categories
use App\Form\CategoriesType; // DM_ ENTITY pour pouvoir utiliser la Classe Categories
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request; //DM_ ajouté sur inspiration RegistrationController.php (ou en prenant la doc symfony : symfony.com/doc/current/forms.html#installation)


/**
 * @Route("/categories", name="categories_")
 */
class CategoriesController extends AbstractController
{
    /**
     * @Route("/new", name="new")
     */
    public function newcat(Request $request): Response
    {
        // le controlleur construit le Formulaire à partir de CategoriesType (CategoriesFormType chez Gilles)
        $categories = new Categories();
        $form = $this->createForm(CategoriesType::class, $categories); //DM_ GILLES on instancie le Formulaire sur le 'moule' CategoriesType 
        $form->handleRequest($request);

        //le controlleur envoi les données du formulaire dans BDD
        if ($form->isSubmitted() && $form->isValid()) { //inspiration RegistrationController.php
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categories); //prendre les donnée du Formulaire et tu les mets dans l'instance $categories
            $entityManager->flush(); //DM_ tu les envois dans la BDD
            return $this->render('home/index.html.twig');
        }
        //le controlleur affiche le template du formulaire
        return $this->render('categories/new_category.html.twig', [
            'categoryForm' => $form->createView(),
        ]);
    }
}
