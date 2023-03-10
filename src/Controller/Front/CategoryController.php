<?php

namespace App\Controller\Front;

use App\Entity\Post;
use App\Entity\Category;
use App\Repository\AuthorRepository;
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{id}-{slug}", name="category_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(
        Category $category, 
        Post $posts = null, 
        CategoryRepository $categoryRepository,
        AuthorRepository $authorRepository,
        PaginatorInterface $paginator, 
        PostRepository $postRepository,
        Request $request): Response
    {
        // Get all categories
        $categories = $categoryRepository->findAll();

        $authors = $authorRepository->findAll();
        // Get the posts by category
        $posts = $paginator->paginate(
            $postRepository->findByCategory(['post' => $posts]),
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        //dd($posts);
        $category = $categoryRepository->find($category);     

        return $this->render('front/category/list.html.twig', [
            'categories' => $categories,
            'category' => $category,
            'authors' => $authors,
            'posts' => $posts,
        ]);
    }
}
