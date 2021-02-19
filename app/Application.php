<?php
namespace Core;

use App\BlogBundle\Controller\FrontController;
use Symfony\Component\HttpFoundation\Request;
use AltoRouter;
use Symfony\Component\HttpFoundation\Response;

class Application
{

    private $request;
    private $response;
    private $config;

    private $router;

    private $reponseContent;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->config = yaml_parse_file('../app/env.yaml');
        $this->response = new Response();

    }

    /**
     * Gestion de notre application afin qu'il puisse rediriger vers le bon controlleur
     */
    public function process()
    {
        $this->router = new AltoRouter();
        $this->processRoute();

        $match = $this->router->match();
        if ($match === false) {
            $this->reponseContent = 'PAGE NOT FOUND.';
            $this->response->setContent($this->reponseContent);
            $this->response->setStatusCode(Response::HTTP_NOT_FOUND);
            $this->response->headers->set('Content-Type', 'text/html');
        } else {
            list($controller, $action) = explode('#', $match['target']);
            $controller = new $controller($this->request, $this->response, $this->router);
            if (is_callable(array($controller, $action))) {
                $this->reponseContent = call_user_func_array(array($controller, $action), $match['params']);
                $this->response->setContent($this->reponseContent);
                $this->response->headers->set('Content-Type', 'text/html');
            } else {
                $this->reponseContent =  'Error: can not call ' . get_class($controller) . '#' . $action;

                if($this->config['app']['env'] === 'dev')
                {
                    $this->response->setContent('Page NOT FOUND');
                    $this->response->setStatusCode(Response::HTTP_NOT_FOUND);

                    $this->response->headers->set('Content-Type', 'text/html');
                }
                else {
                    $this->response->setContent('Erreur 500.');
                    $this->response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                    $this->response->headers->set('Content-Type', 'text/html');
                }

            }
        }
        return $this;
    }

    private function processRoute()
    {
        $file = yaml_parse_file('../app/routes.yaml');
        foreach ($file['routes'] as $route)
        {
            $this->router->map($route['method'],$route['path'], sprintf('%s#%s', $route['class'], $route['action']), $route['name']);
        }
    }

    public function send(): Response
    {
        return $this->response->send();
    }
}