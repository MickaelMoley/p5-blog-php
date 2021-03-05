<?php


namespace App\BlogBundle\Controller;


use AltoRouter;
use App\BlogBundle\Model\Post;
use App\BlogBundle\Repository\PostRepository;
use App\CoreBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostControllerAdmin extends Controller
{

    private $manager;


    /**
     * @param null $params
     */
    public function list($params = null)
    {
        $postRepo = new PostRepository();
        $posts = $postRepo->findAll();


        return $this->render('dashboard/post/list.html.twig', [
            'posts' => $posts,
        ]);

    }

    /*
     * Permet de créer un article
     */
    public function create($params = null): string
    {


        $post = $post = new Post();

        //TODO:: Vérifier que le token est OK

        $form = $this->getDataForm(Post::class, $post);

        $form->handleRequest($this->request);

        if($form->isSubmitted())
        {
            $data = $form->getData();

            $data->setCreatedAt(new \DateTime('now'));
            $data->setUpdatedAt(new \DateTime('now'));
            $lastId = $this->manager->persist($data);
            return $this->redirectToRoute('edit_post',  ['id' => $lastId]);
        }

        return $this->render('dashboard/post/create.html.twig');
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

            return $this->redirectToRoute('edit_post',  ['id' => $data->getId()]);
        }


        return $this->render('dashboard/post/edit.html.twig', [
            'form' => $form->createView(),
            'route' => $this->getCurrentRoute()
        ]);
    }

    /*
     * Permet de supprimer un article
     */
    public function delete($params = null)
    {
        $post = $this->manager->find($params);

        if($post)
        {
            $this->manager->postDelete($post);
        }

        return $this->redirectToRoute('list_post', []);
    }
}