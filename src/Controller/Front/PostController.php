<?php

namespace App\Controller\Front;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @return Response
     * 
     * @Route("/", name="post_home", methods={"GET"})
     */
    public function home(ManagerRegistry $doctrine): Response
    {
        $posts = $doctrine->getRepository(Post::class)->findAll();

        return $this->render('front/home/home.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/{id}", name="post_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Post $post): Response
    {
        return $this->render('front/show.html.twig', [
            'post' => $post,
        ]);
    }

}
