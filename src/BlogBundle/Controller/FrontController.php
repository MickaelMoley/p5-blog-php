<?php


namespace App\BlogBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\CoreBundle\Controller\Controller;
use Twig\Loader\ArrayLoader;
use Twig\Environment;

class FrontController extends Controller
{

    public function index(): string
    {



        return $this->render('front/index.html.twig');
//        return $this->currentPath();
    }

    public function edit($params): string
    {

        return $this->render('edit.html.twig', ['name' => 'Post']);
//        return $this->currentPath();
    }
}