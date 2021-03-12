<?php
namespace Core;

use App\BlogBundle\Controller\FrontController;
use Symfony\Component\HttpFoundation\Request;
use AltoRouter;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Application
{

    private $request;
    private $response;
    private $config;

    private $router;

    private $reponseContent;

    private $debug = true;
    private $entityManager;

    public function __construct(Request $request = null)
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
        session_start();

        $this->router = new AltoRouter();
        $this->processRoute();
        $this->processDatabaseManager();

        $match = $this->router->match();
        if ($match === false) {
            $this->reponseContent = 'PAGE NOT FOUND.';
            $this->response->setContent($this->reponseContent);
            $this->response->setStatusCode(Response::HTTP_NOT_FOUND);
            $this->response->headers->set('Content-Type', 'text/html');
        } else {
            list($controller, $action) = explode('#', $match['target']);
            $params['env'] = $this->config['app']['env'];
            $params['entityManager'] = $this->entityManager;


            $controller = new $controller($this->request, $this->response, $this->router, $params);
            if (is_callable(array($controller, $action))) {
                $content = call_user_func_array(array($controller, $action), $match['params']);
//                dump($content);
                if(gettype($content) === 'object')
                {
                    $this->response = $content;
                }
                else if(gettype($content) === 'string')
                {
                    $this->response->setContent($content);
                }


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

    public function processDatabaseManager()
    {
        // the connection configuration
        $dbParams = array(
            'driver'   => 'pdo_mysql',
            'user'     => 'symfony',
            'password' => 'Hallucinations0617!K',
            'dbname'   => 'blog_doctrine',
        );

        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/../src/BlogBundle/Entity'), $this->debug,null, null, false);
        try {
            return $this->entityManager = EntityManager::create($dbParams, $config);
        } catch (\Doctrine\ORM\ORMException $e) {
            echo $e->getMessage();
        }
    }

    public function send(): Response
    {
        return $this->response->send();
    }
}