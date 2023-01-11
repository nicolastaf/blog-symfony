<?php

namespace App\Controller\Front;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/front/author")
 */
class AuthorController extends AbstractController
{
    /**
     * @Route("/auteur/list", name="author_list", methods={"GET"})
     */
    public function list(ManagerRegistry $doctrine): Response
    {
        $authors = $doctrine->getRepository(Author::class)->findAll();

        return $this->render('front/author/list.html.twig', [
            'authors' => $authors,
        ]);
    }

    /**
     * @Route("/auteur/{id}", name="author_show", methods={"GET"})
     */
    public function show(Author $author): Response
    {
        return $this->render('front/author/show.html.twig', [
            'author' => $author,
        ]);
    }

}
