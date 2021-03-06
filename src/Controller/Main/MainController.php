<?php

namespace App\Controller\Main;

use App\Form\ContactsType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(Request $request, CategorieRepository $categorieRepository): Response
    {

        // $form = $this->createForm(ContactMainType::class);

        // $contact = $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) { 

        //     $sujet = $contact->get('sujet')->getData();
        //     $message = $contact->get('message')->getData();

        //     $mail = new Mail();
        //     $mail->sendToAdmin($message, $sujet);

        //     $this->addFlash(
        //        'message',
        //        'Votre email a bien ete envoyez. nous recontacterons sous peu'
        //     );
        // }

        return $this->render('main/index.html.twig', [
            "categories" => $categorieRepository->findAll(),
            // "form"=>$form->createView()
        ]);
    }

    /**
     * @Route("/categories", name="categories")
     */
    public function categories(CategorieRepository $categorieRepository): Response
    {
        return $this->render('main/categories.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/categories/{id}", name="detail_categories")
     */
    public function detailCategories($id, CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->find($id);
        $formation = $categories->getFormations();
        $nom = $categories->getNom();
        $description = $categories->getDescription();
        $petitedescription = $categories->getPetitedescription();

        return $this->render('main/detailCategories.html.twig', [
            "nom" => $nom,
            "description" => $description,
            "petitedescription" => $petitedescription,
            'formations' => $formation
        ]);
    }

    /**
     * @Route("/formation", name="formations")
     */
    public function formation(
        FormationRepository $formationRepository,
        CategorieRepository $categorieRepository,
        CacheInterface $cacheInterface,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        // $formation = $cacheInterface->get("formation_liste_main", function (ItemInterface $itemInterface) use ($formationRepository) {
        //     $itemInterface->expiresAfter(20);
        //     return $formationRepository->findBy(["isActif" => true], ["datePublication" => 'DESC']);
        // });

        $donnes = $formationRepository->findBy(["isActif" => true], ["datePublication" => 'DESC']);

        $formation = $paginator->paginate($donnes, $request->query->getInt('page', 1), 3);


        return $this->render('main/formation.html.twig', [
            "formations" => $formation
        ]);
    }

    /**
     * @Route("/formation/{id}", name="detail_formation")
     */
    public function detailFormation($id, FormationRepository $formationRepository): Response
    {
        $formation = $formationRepository->find($id);

        $titre = $formation->getTitre();
        $description = $formation->getDescription();
        $nombrePlace = $formation->getNombrePlace();
        $dateDebutFormation = $formation->getDateDebutFormation();
        $dateFinFormation = $formation->getDateFinFormation();
        $datePublication = $formation->getDatePublication();

        return $this->render('main/detailFormation.html.twig', [
            "formation" => $formation,
            "titre" => $titre,
            "description" => $description,
            "nombrePlace" => $nombrePlace,
            "dateDebutFormation" => $dateDebutFormation,
            "dateFinFormation" => $dateFinFormation,
            "datePublication" => $datePublication
        ]);
    }

    public function fonctionLongue()
    {
        sleep(3);
        return " cool";
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request): Response
    {
        $form = $this->createForm(ContactsType::class);
        
        $form->handleRequest($request);
        
        dd($request);
        if ($form->isSubmitted() && $form->isValid()) { 
        }

        return $this->render('main/contacts.html.twig', [
            "form"=> $form->createView()
        ]);
    }
}
