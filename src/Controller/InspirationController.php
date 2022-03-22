<?php

namespace App\Controller;

use App\Entity\Inspiration;
use App\Service\Search;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class InspirationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
/* INDEX */
    #[Route('/inspirations', name: 'inspirations')]
    public function index(Request $request): Response
    {
        $search = new Search(); 
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $inspirations = $this->entityManager->getRepository(Inspiration::class)->findBySearch($search); /* SEARCH */
            /* findBySearch is manually created in InspirationRepository.php */
        } else{
            $inspirations = $this->entityManager->getRepository(Inspiration::class)->findAll(); /* INDEX */
        }
        
        return $this->render('inspiration/index.html.twig', [
            'inspirations' => $inspirations,
            'form' => $form->createView()
        ]);
    }
/* SHOW */
    #[Route('/inspiration/{slug}', name: 'inspiration')]
    public function show($slug): Response
    {
        $inspiration = $this->entityManager->getRepository(Inspiration::class)->findOneBySlug($slug);
        $items = $inspiration->getItems();

        if (!$inspiration) {
            return $this->redirectToRoute('inspirations');
        }

        return $this->render('inspiration/show.html.twig', [
            'inspiration' => $inspiration,
            'items' => $items,
        ]);
    }
}
