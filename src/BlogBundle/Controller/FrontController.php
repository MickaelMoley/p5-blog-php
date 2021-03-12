<?php


namespace App\BlogBundle\Controller;


use App\BlogBundle\Entity\Comment;
use App\BlogBundle\Entity\Post;
use App\BlogBundle\Entity\User;
use App\BlogBundle\Repository\PostRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\CoreBundle\Controller\Controller;
use Twig\Loader\ArrayLoader;
use Twig\Environment;

class FrontController extends Controller
{

    public function index()
    {

        $em = $this->getEntityManager();

        $posts = $em->getRepository(Post::class)->findAll();

       return $this->render('front/index.html.twig');


    }

    public function edit($params): string
    {

        return $this->render('edit.html.twig', ['name' => 'Post']);
//        return $this->currentPath();
    }

    public function listPost($params = null)
    {


        $em = $this->getEntityManager();
        $posts = $em->getRepository(Post::class)->findAll();


        return $this->render('front/post/list.html.twig', ['posts' => $posts]);
    }

    public function showPost($params = null)
    {

//        dump($this->request);
        $em = $this->getEntityManager();
        $post = $em->getRepository(Post::class)->find($params);
        $comments = $em->getRepository(Comment::class)->findPublishComments($post);

        return $this->render('front/post/show.html.twig', [
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    public function createComment($params = null)
    {



        $em = $this->getEntityManager();
        $post = $em->getRepository(Post::class)->find($params);
        $user = $this->getUser();


        $comment = new Comment();
        $comment->setAuthor($user);
        $comment->setPost($post);
        $comment->setMessage($this->request->request->get('form')['message']);
        $comment->setCreatedAt(new \DateTime('now'));
        $comment->setStatus(0);

        $em->persist($comment, $user);
        $em->flush();


        return $this->redirectToRoute('show_front_post',  ['id' => $post->getId()]);
    }

    public function contact($params = null)
    {
        $data = $this->request->request->get('form');


        // TODO: Envoie des mails

        return $this->render('front/contact.html.twig');
    }
}