<?php

namespace App\Controller\Blog;

use App\Repository\Post\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{


    #[Route('/', name: 'post_index', methods: ['GET'])]
    public  function index(
        PostRepository $postRepository,
        Request $request
    ): Response {

        return $this->render('pages/blog/index.html.twig', [
            'posts' => $postRepository->findPublishedPosts($request->query->getInt('page', 1))
        ]);
    }
}
