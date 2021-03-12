<?php


namespace App\BlogBundle\Controller;


use App\BlogBundle\Entity\Comment;
use App\BlogBundle\Entity\Post;
use App\BlogBundle\Entity\User;
use App\BlogBundle\Repository\PostRepository;
use App\CoreBundle\Security\Authentification;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\CoreBundle\Controller\Controller;
use Twig\Loader\ArrayLoader;
use Twig\Environment;

class SecurityController extends Controller
{

    public function register()
    {
        $em = $this->getEntityManager();
        $user = new User();


        $form = $this->getDataForm(User::class, $user);

        $form->handleRequest($this->request);

        if($form->isSubmitted())
        {
            $data = $form->getData();
            $data->setRoles('ROLE_SUPER_ADMIN');

            $em->persist($data);
            $em->flush();


         return new Response('compte crée');
        }

        return $this->render('security/register.html.twig');
    }

    public function login()
    {
        if($this->getUser())
        {
            if($this->isGranted('ROLE_USER'))
            {
                return $this->redirectToRoute('list_front_post');
            }
            else {
                return $this->redirectToRoute('list_post');
            }
        }
        else {

            $data = $this->request->request->get('form');

            if(isset($data['email']) && $data['password'])
            {
                Authentification::login($data['email'], $data['password'], $this->getEntityManager());
            }
        }

        return $this->render('security/login.html.twig');
    }
}