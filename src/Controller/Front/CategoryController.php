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
    public function show(Category $category, Post $posts = null, CategoryRepository $categoryRepository, PostRepository $postRepository): Response
    {
        // Get all categories
        $categories = $categoryRepository->findAll();
        // Get the posts by category
        $posts = $postRepository->findByCategory(['post' => $posts]);
        //dd($posts);
        $category = $categoryRepository->find($category);     

        return $this->render('front/category/list.html.twig', [
            'categories' => $categories,
            'category' => $category,
            'posts' => $posts,
        ]);
    }
}
