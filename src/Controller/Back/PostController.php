<?php

namespace App\Controller\Back;

use App\Entity\Post;
use App\Form\PostType;
use DateTimeImmutable;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="app_back_post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('back/post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_back_post_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PostRepository $postRepository): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postRepository->add($post, true);

            $this->addFlash('success', 'L\'article à bien été ajouté');

            return $this->redirectToRoute('app_back_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_post_show", methods={"GET"})
     */
    public function show(Post $post): Response
    {
        return $this->render('back/post/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @IsGranted("ROLE_MANAGER")
     * @Route("/{id}/edit", name="app_back_post_edit", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function edit(Request $request, Post $post, PostRepository $postRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MANAGER', $post);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setUpdatedAt(new DateTimeImmutable());
            $postRepository->add($post, true);

            $this->addFlash('success', 'L\'article à bien été modifié');

            return $this->redirectToRoute('app_back_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_post_delete", methods={"POST"})
     */
    public function delete(Request $request, Post $post, PostRepository $postRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $postRepository->remove($post, true);

            $this->addFlash('success', 'L\'article à bien été supprimé');
        }

        return $this->redirectToRoute('app_back_post_index', [], Response::HTTP_SEE_OTHER);
    }
}
