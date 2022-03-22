<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Header;
use App\Entity\Inspiration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $items = $this->entityManager->getRepository(Item::class)->findByIsPopular(1);
        $inspirations = $this->entityManager->getRepository(Inspiration::class)->findByIsPopular(1);
        $headers = $this->entityManager->getRepository(Header::class)->findAll();


        return $this->render('home/index.html.twig',[
            'items' => $items,
            'inspirations' => $inspirations,
            'headers' => $headers
        ]);
    }
}
