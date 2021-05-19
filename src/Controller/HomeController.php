<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\User;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    // Page d'acceuil
    public function index(BookRepository $repo, UserRepository $userRepo): Response
    {
        $books = $repo->findAll();
        $user = $this->getUser();

        // dd($user);
        // dd($books[1]->getPublishedDate());
        return $this->render('home/index.html.twig', [
            'books' => $books,
            'user' => $user
        ]);

    }
}
