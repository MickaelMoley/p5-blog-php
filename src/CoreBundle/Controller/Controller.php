<?php


namespace App\CoreBundle\Controller;
use App\CoreBundle\Form\FormBase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use AltoRouter;


class Controller
{

    private $loader;
    private $twig;
    protected $request;
    protected $response;
    private $uniq;
    protected $router;
    private $params;

    public function __construct(Request $request, Response $response, AltoRouter $router, $params)
    {
        $this->loader = new FilesystemLoader('../src/BlogBundle/View/');
        $this->twig = new Environment($this->loader, [
            'cache' => '../var/cache/twig/',
            'debug' => true
        ]);
        $this->request = $request;
        $this->response = $response;
        $this->uniq = 's96699';
        $this->router = $router;
        $this->params = $params;
    }

    public function getEnvironnement()
    {
        return $this->params['env'];
    }

    public function render($template, $params = []): string
    {
        try {
            //On passe les routes
            $params['route'] = (array)$this->router->match();

            $render = $this->twig->render($template, $params);

            if($render)
            {
//                $this->response->setStatusCode(Response::HTTP_OK);
                return $render;
            }

        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            return $e->getMessage();
        }
    }

    public function redirectToRoute($name, $params = [])
    {
        try {
            return new RedirectResponse($this->router->generate($name, $params));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getCurrentRoute()
    {
        return $this->router->match();
    }


    public function getDataForm($class, $data)
    {
        $form = new FormBase($class, $data);

        return $form->init();
    }

    public function currentPath()
    {
        return __DIR__;
    }

}