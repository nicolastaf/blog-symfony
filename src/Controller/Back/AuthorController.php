<?php

namespace App\Controller\Back;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back/author")
 */
class AuthorController extends AbstractController
{
    /**
     * @Route("/", name="app_back_authors_index", methods={"GET"})
     */
    public function index(AuthorRepository $authorRepository): Response
    {
        return $this->render('back/author/index.html.twig', [
            'authors' => $authorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_back_author_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AuthorRepository $authorRepository): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $authorRepository->add($author, true);

            $this->addFlash('success', 'L\'auteur à bien été ajouté');

            return $this->redirectToRoute('app_back_authors_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/author/new.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_author_show", methods={"GET"})
     */
    public function show(Author $author): Response
    {
        return $this->render('back/author/show.html.twig', [
            'author' => $author,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_author_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Author $author, AuthorRepository $authorRepository): Response
    {
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $author->setUpdatedAt(new DateTimeImmutable());
            $authorRepository->add($author, true);

            $this->addFlash('success', 'L\'auteur à bien été modifié');

            return $this->redirectToRoute('app_back_authors_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/author/edit.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_author_delete", methods={"POST"})
     */
    public function delete(Request $request, Author $author, AuthorRepository $authorRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$author->getId(), $request->request->get('_token'))) {
            $authorRepository->remove($author, true);

            $this->addFlash('success', 'L\'auteur à bien été supprimé');
        }

        return $this->redirectToRoute('back_app_authors_index', [], Response::HTTP_SEE_OTHER);
    }
}
