<?php

namespace App\Controller\Front;

use App\Entity\Post;
use App\Entity\Category;
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @Route("/front/category", name="app_front_category")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('front/category/index.html.twig', [
            'categoryRepository' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/category/{id}-{slug}", name="category_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Post $posts, CategoryRepository $categoryRepository, PostRepository $postRepository): Response
    {
        $categories = $categoryRepository->findAll();
        $posts = $postRepository->findByCategory(['post' => $posts]);
        //dd($posts);

        return $this->render('front/category/list.html.twig', [
            'categories' => $categories,
            'posts' => $posts,
        ]);
    }
}
