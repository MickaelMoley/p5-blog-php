<?php


namespace App\BlogBundle\Controller;


use App\BlogBundle\Model\Post;
use App\BlogBundle\Repository\PostRepository;
use App\CoreBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{


    /*
     * Permet de créer un article
     */
    public function create($params = null): string
    {


        $postRepo = new PostRepository();
        $post = $post = new Post();

        //TODO:: Vérifier que le token est OK

        $form = $this->getDataForm(Post::class, $post);

        $form->handleRequest($this->request);

        if($form->isSubmitted())
        {
            $data = $form->getData();

            $data->setCreatedAt(new \DateTime('now'));
            $data->setUpdatedAt(new \DateTime('now'));
            $postRepo->persist($data);

            return $this->render('post/edit.html.twig', [
                'form' => $form->createView()
            ]);
        }

        return $this->render('post/create.html.twig');
    }

    /*
     * Permet de modifier un article
     */
    public function edit($params = null): string
    {
        $postRepo = new PostRepository();
        $post = $postRepo->find($params);

        //TODO:: Vérifier que le token est OK

        $form = $this->getDataForm(Post::class, $post);

        $form->handleRequest($this->request);

        if($form->isSubmitted())
        {
            $data = $form->getData();
            $data->setUpdatedAt(new \DateTime('now'));
            $postRepo->persist($data);

            return $this->render('post/edit.html.twig', [
                'form' => $form->createView()
            ]);
        }


        return $this->render('post/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}