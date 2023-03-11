<?php

namespace App\Controller;

use App\Entity\Inspiration;
use App\Entity\Item;
use App\Service\Filter;
use App\Form\FilterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ItemController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
/* INDEX */
    #[Route('/articles', name: 'items')]
    public function index(Request $request): Response
    {
        $filter = new Filter(); 
        $form = $this->createForm(FilterType::class, $filter);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $items = $this->entityManager->getRepository(Item::class)->findByFilter($filter); /* FILTER */
            /* findByFilter is manually created in ItemRepository.php */
        } else{
            $items = $this->entityManager->getRepository(Item::class)->findAll(); /* INDEX */
        }
        
        return $this->render('item/index.html.twig', [
            'items' => $items,
            'form' => $form->createView()
        ]);
    }
/* SHOW */
    #[Route('/article/{slug}', name: 'item')]
    public function show($slug): Response
    {
        $item = $this->entityManager->getRepository(Item::class)->findOneBySlug($slug);
        $inspirations = $item->getInspirations();

        if (!$item) {
            return $this->redirectToRoute('items');
        }

        return $this->render('item/show.html.twig', [
            'item' => $item,
            'inspirations' => $inspirations,
        ]);
    }
}
