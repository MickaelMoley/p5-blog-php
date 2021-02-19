<?php


namespace App\BlogBundle\Repository;


use App\BlogBundle\Model\Post;
use App\CoreBundle\Database\Repository;

class PostRepository extends Repository
{
    protected $class = Post::class;
    protected $className = Post::_className;


    public function postDelete($object)
    {
        try {
            // Supprimer les commentaires
            $repoComment = new CommentRepository();
            $comments = $repoComment->findBy(['post_id' => $object->getId()]);
            foreach ($comments as $comment)
            {
                $repoComment->delete($comment);
            }

            //Supprime l'article
            $repoPost = new PostRepository();
            return $repoPost->delete($object);
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }

    }
}