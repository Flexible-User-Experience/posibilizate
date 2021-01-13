<?php

namespace App\Controller;

use App\Repository\BlogPostRepository;
use DateTime;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/blog/no-se-que-hacer-con-mi-vida/{year}/{month}/{day}/{slug}", name="app_front_blog_post_detail")
     */
    public function blogFirstPostAction(string $year, string $month, string $day, string $slug, BlogPostRepository $bpr): Response
    {
        $published = new DateTime();
        $published->setDate((int) $year, (int) $month, (int) $day);
        $post = $bpr->findByPublishedAndSlug($published, $slug)->getQuery()->getOneOrNullResult();
        if (!$post) {
            throw $this->createNotFoundException();
        }
        $today = new DateTimeImmutable();
        if ($today->format('Y-m-d') < $published->format('Y-m-d')) {
            throw $this->createNotFoundException();
        }
        if (!$post->isAvailable()) {
            throw $this->createAccessDeniedException();
        }

        return $this->render(
            'blog/post_detail.html.twig',
            [
                'post' => $post,
            ]
        );
    }
}
