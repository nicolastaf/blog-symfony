<?php

namespace App\Controller\Front;

use App\Entity\Comment;
use App\Entity\Post;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment/add", name="comment_addValid", methods={"POST"})
     */
    public function addValid(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();

        $comment = new Comment();

        $post = $entityManager->getRepository(Post::class)->find($request->get('post'));

        $comment->setUsername($request->get('username'));
        $comment->setBody($request->get('body'));
        $comment->setPost($post);
        $comment->setPublishedAt((new DateTimeImmutable('NOW')));
        $comment->setCreatedAt((new DateTimeImmutable('NOW')));
        $comment->setUpdatedAt((new DateTimeImmutable('NOW')));

        $entityManager->persist($comment);
        $entityManager->flush();

        return $this->redirect($request->headers->get('referer'));
    }
}
