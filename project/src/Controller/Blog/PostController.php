<?php

namespace App\Controller\Blog;

use App\Repository\Post\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{


    #[Route('/', name: 'post_index', methods: ['GET'])]
    public  function index(PostRepository $postRepository): Response
    {


        $posts = $postRepository->findPublishedPosts();



        return $this->render('pages/blog/index.html.twig', [
            'posts' => $posts
        ]);
    }
}
