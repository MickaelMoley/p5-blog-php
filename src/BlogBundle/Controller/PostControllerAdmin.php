<?php


namespace App\BlogBundle\Controller;


use AltoRouter;
use App\BlogBundle\Entity\User;
use App\BlogBundle\Model\Post;
use App\BlogBundle\Repository\PostRepository;
use App\CoreBundle\Controller\Controller;
use App\CoreBundle\Security\Authentification;
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

        $em = $this->getEntityManager();
        $posts = $em->getRepository(\App\BlogBundle\Entity\Post::class)->findAll();


        return $this->render('dashboard/post/list.html.twig', [
            'posts' => $posts,
        ]);

    }

    /*
     * Permet de créer un article
     */
    public function create($params = null): string
    {

        $em = $this->getEntityManager();
        $post = new \App\BlogBundle\Entity\Post();
        $users = $em->getRepository(User::class)->findAll();

        //TODO:: Vérifier que le token est OK

        $form = $this->getDataForm(Post::class, $post);

        $form->handleRequest($this->request);

        $user = $this->getUser();

        if($form->isSubmitted())
        {
            $data = $form->getData();
            $requestData = $form->getRequestData();

            $data->setCreatedAt(new \DateTime('now'));
            $data->setUpdatedAt(new \DateTime('now'));

            //On défini l'utilisateur courant ou l'utilisateur attribué
            if($requestData['author'] === $user->getId())
            {
                $data->setAuthor($user);
            }
            else {
                $user = $em->getRepository(User::class)->find($requestData['author']);
                $data->setAuthor($user);
            }


            $em->persist($data);
            $em->flush();
            return $this->redirectToRoute('edit_post',  ['id' => $data->getId()]);
        }

        return $this->render('dashboard/post/create.html.twig', [
            'users' => $users
        ]);
    }

    /*
     * Permet de modifier un article
     */
    public function edit($params = null): string
    {
        $em = $this->getEntityManager();
        $post = $em->getRepository(\App\BlogBundle\Entity\Post::class)->find($params);

        $user = $this->getUser();
        $users = $em->getRepository(User::class)->findAll();

        //TODO:: Vérifier que le token est OK

        $form = $this->getDataForm(\App\BlogBundle\Entity\Post::class, $post);
//        dump($post);
//        dump($form);
        $form->handleRequest($this->request);

        if($form->isSubmitted())
        {
            $data = $form->getData();
//            dump($data);
            $requestData = $form->getRequestData();

            $data->setUpdatedAt(new \DateTime('now'));

            //On défini l'utilisateur courant ou l'utilisateur attribué*
            if(isset($requestData['author']) && !is_null($requestData['author']))
            {
                if($requestData['author'] === $user->getId())
                {
                    $data->setAuthor($user);
                }
                else {
                    $user = $em->getRepository(User::class)->find($requestData['author']);
                    $data->setAuthor($user);
                }
            }


            $em->persist($data);
            $em->flush();

            return $this->redirectToRoute('edit_post',  ['id' => $data->getId()]);
        }
        return $this->render('dashboard/post/edit.html.twig', [
            'form' => $form->createView(),
            'route' => $this->getCurrentRoute(),
            'users' => $users
        ]);
    }

    /*
     * Permet de supprimer un article
     */
    public function delete($params = null)
    {
        $em = $this->getEntityManager();

        $post = $em->getRepository(\App\BlogBundle\Entity\Post::class)->find($params);

        if($post)
        {
            $em->remove($post);
            $em->flush();
        }

        return $this->redirectToRoute('list_post', []);
    }
}