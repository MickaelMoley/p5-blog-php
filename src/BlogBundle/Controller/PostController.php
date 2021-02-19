<?php


namespace App\BlogBundle\Controller;


use AltoRouter;
use App\BlogBundle\Model\Post;
use App\BlogBundle\Repository\PostRepository;
use App\CoreBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{

    private $manager;

    public function __construct(Request $request, Response $response, AltoRouter $router)
    {
        parent::__construct($request, $response, $router);

        $this->manager = new PostRepository();
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

            return $this->redirectToRoute('edit_post',  ['id' => $data->getId()]);
        }


        return $this->render('post/edit.html.twig', [
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

        return $this->redirectToRoute('create_post', []);
    }
}