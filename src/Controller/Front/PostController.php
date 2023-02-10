<?php

namespace App\Controller\Front;

use App\Entity\Post;
use App\Form\PostType;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    /**
     * @return Response
     * 
     * @Route("/", name="post_home", methods={"GET"})
     */
    public function home(
        PostRepository $postRepository, 
        PaginatorInterface $paginator,
        CategoryRepository $categoryRepository, 
        Request $request): Response
    {
        $categories = $categoryRepository->findAll();

        $posts = $paginator->paginate(
            $postRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('front/home/home.html.twig', [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/{id}-{slug}", name="post_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Post $post): Response
    {
        return $this->render('front/post/show.html.twig', [
            'post' => $post,
        ]);
    }

}
