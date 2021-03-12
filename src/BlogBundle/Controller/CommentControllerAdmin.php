<?php


namespace App\BlogBundle\Controller;


use AltoRouter;
use App\BlogBundle\Entity\Comment;
use App\BlogBundle\Entity\User;
use App\BlogBundle\Model\Post;
use App\CoreBundle\Controller\Controller;


class CommentControllerAdmin extends Controller
{

    private $manager;


    /**
     * @param null $params
     */
    public function list($params = null)
    {
        $em = $this->getEntityManager();
        $comments = $em->getRepository(Comment::class)->findAll();


        return $this->render('dashboard/comment/list.html.twig', [
            'comments' => $comments,
        ]);

    }

    /*
     * Permet de créer un commentaire
     */
    public function create($params = null): string
    {

        $em = $this->getEntityManager();
        $comment = new Comment();


        $user = $this->getUser();
        $post = $em->getRepository(\App\BlogBundle\Entity\Post::class)->find(11);
        $comment->setPost($post);
        $comment->setAuthor($user);

        //TODO:: Vérifier que le token est OK

        $form = $this->getDataForm(Comment::class, $comment);
//        dump($post);
//        dump($form);
        $form->handleRequest($this->request);

        if($form->isSubmitted())
        {
            $data = $form->getData();
//            dump($data);
            $requestData = $form->getRequestData();
            $data->setCreatedAt(new \DateTime('now'));

            $em->persist($data);
            $em->flush();

            return $this->redirectToRoute('edit_comment',  ['id' => $data->getId()]);
        }
        return $this->render('dashboard/comment/create.html.twig', [
            'form' => $form->createView(),
            'route' => $this->getCurrentRoute(),
        ]);
    }

    /*
     * Permet de modifier un article
     */
    public function edit($params = null): string
    {
        $em = $this->getEntityManager();
        $comment = $em->getRepository(Comment::class)->find($params);

        $user = $this->getUser();

        //TODO:: Vérifier que le token est OK

        $form = $this->getDataForm(Comment::class, $comment);
//        dump($post);
//        dump($form);
        $form->handleRequest($this->request);

        if($form->isSubmitted())
        {
            $data = $form->getData();
//            dump($data);
            $requestData = $form->getRequestData();

            $em->persist($data);
            $em->flush();

            return $this->redirectToRoute('edit_comment',  ['id' => $data->getId()]);
        }
        return $this->render('dashboard/comment/edit.html.twig', [
            'form' => $form->createView(),
            'route' => $this->getCurrentRoute(),
        ]);
    }

    /*
     * Permet de supprimer un article
     */
    public function delete($params = null)
    {
        $em = $this->getEntityManager();

        $comment = $em->getRepository(\App\BlogBundle\Entity\Comment::class)->find($params);

        if($comment)
        {
            $em->remove($comment);
            $em->flush();
        }

        return $this->redirectToRoute('list_comment', []);
    }
}