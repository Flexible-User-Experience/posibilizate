<?php

namespace App\Controller;

use App\Repository\BlogPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog/no-se-que-hacer-con-mi-vida", name="app_front_blog_landing")
     */
    public function blogLandingAction(BlogPostRepository $bpr): Response
    {
        $posts = $bpr->findUpTodayAvailableSortedByPublishedDateAndName()->getQuery()->getResult();

        return $this->render(
            'blog/landing.html.twig',
            [
                'posts' => $posts,
            ]
        );
    }

    /**
     * @Route("/blog/no-se-que-hacer-con-mi-vida/2021/01/15/la-duda-como-palanca-de-cambio", name="app_front_blog_first_post")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function blogFirstPostAction(Request $request): Response
    {
        return $this->render('blog/first_post.html.twig');
    }
}
