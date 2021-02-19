<?php

require_once '../vendor/autoload.php';
use app\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use App\CoreBundle\Database\Database;
use App\BlogBundle\Model\Post;
use App\CoreBundle\Database\Utils\ObjectComparator;
use App\CoreBundle\Database\Model;
use App\BlogBundle\Model\Comment;
use App\BlogBundle\Model\User;
use App\CoreBundle\Database\Repository as Manager;
use App\BlogBundle\Repository\PostRepository;
use App\BlogBundle\Repository\UserRepository;
use App\BlogBundle\Repository\CommentRepository;
use App\BlogBundle\Controller\FrontController;

$request = Request::createFromGlobals();






//Application::process($request);


//$pdo = new PDO("mysql:host=127.0.0.1;dbname=p5;charset=utf8", 'symfony', 'Hallucinations0617!K', [
//        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
//    ]);

$config = yaml_parse_file('config.yaml');

$pdo = new PDO("mysql:host=". $config['database']['host'] .";dbname=".$config['database']['db_name'].";charset=utf8",
    $config['database']['user'], $config['database']['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
//
//
//$user = $pdo->query('SELECT * FROM post LIMIT 1')->fetchObject('Post');
//echo $user->getId();
//$user->setId(5);

try {
//    $database = new Database();
    $newPost = new Post();
    $repo = new PostRepository();
    $authorRepo = new UserRepository();
    //Si je souhaite récupérer tous les objets
    $posts = $repo->findAll();
//    $users = $authorRepo->findAll();


//    $newPost->setTitle('Hello there !');
//    $newPost->setContent('Hello my bro!');
//    $newPost->setCreatedAt(new \DateTime('now'));
//    $newPost->setUpdatedAt(new \DateTime('now'));
//
//    $author = new User();
//    $author->setUsername('Bob');
//    $author->setEmail('bob@mail.com');
//    $author->setPassword('1234');
//    $author->setRole('ROLE_COMMENT');
//    $newPost->setAuthorId($author);
//    $authorRepo->persist($author);
//    $repo->persist($newPost);

//    $repo->persist($post);
    $posts[0]->setTitle('Hello');
    $repo->persist($posts[0]);
    dump($posts, $posts[0]);

//    $comment = new Comment();
//    $articles = new Post();
//    $users = new User();
////    $comment->findAll();
//    dump( $comment->findAll(), $articles->findAll(), $users->findAll());die;
//
//    $article2 = $pdo->query('SELECT * FROM `post` WHERE `id` = 1')->fetchObject(Post::class);

    /**
     *
     */
//    $article = new Manager->find(Post::class, 1);
//    $user = new Manager::find(User::class, 2);
//    $comment = new Manager::findAll(Comment::class);

    ///////////////////////////////////////////////
    ///
    ///
//    $pdo->query('SELECT * FROM comment WHERE id = 1')->fetchObject(\App\BlogBundle\Model\Comment::class);

//    $post = new Post();
//    $post->setTitle('Hello there !');
//    $post->setContent('Yes');
//    $post->setExcerpt('yep');
//    $post->setCreatedAt(new \DateTime('now'));
//    $post->setPublished(true);
//    $post->setStatus('waiting');

//    $diff = ObjectComparator::diff($article, $article2);

//    dump($article2);
//    dump($diff);


}
catch (\PDOException $exception)
{
    dump($exception->getMessage());
}

