<?php

namespace App\Controller\Front;

use App\Entity\Post;
use App\Entity\Author;
use App\Repository\PostRepository;
use App\Repository\AuthorRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AuthorController extends AbstractController
{
    /**
     * @Route("/auteur/list", name="author_list", methods={"GET"})
     */
    // public function list(AuthorRepository $authorRepository): Response
    // {

    //     return $this->render('front/home/home.html.twig', [
    //         'authors' => $authorRepository->findAll(),
    //     ]);
    // }

    /**
     * @Route("/auteur/{id}", name="author_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(
        Author $author, 
        Post $posts = null, 
        AuthorRepository $authorRepository,
        PaginatorInterface $paginator, 
        PostRepository $postRepository,
        Request $request): Response
    {
        // Get all authors
        $authors = $authorRepository->findAll();
        // Get the posts by author
        $posts = $paginator->paginate(
            $postRepository->findByAuthor(['post' => $posts]),
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        // dd($posts);
        $author = $authorRepository->find($author);     

        return $this->render('front/author/list.html.twig', [
            'authors' => $authors,
            'author' => $author,
            'posts' => $posts,
        ]);
    }

}
