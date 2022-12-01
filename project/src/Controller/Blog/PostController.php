<?php

namespace App\Controller\Blog;

use App\Repository\Post\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{


    #[Route('/', name: 'post_index', methods: ['GET'])]
    public  function index(
        PostRepository $postRepository,
        PaginatorInterface $paginatorInterface,
        Request $request
    ): Response {


        $data = $postRepository->findPublishedPosts();
        // pas de logique métier dans le controlle knp

        $posts = $paginatorInterface->paginate(
            $data,
            $request->query->getInt('page', 1),
            9

        );



        return $this->render('pages/blog/index.html.twig', [
            'posts' => $posts
        ]);
    }
}
