<?php


namespace App\BlogBundle\Repository;


use App\BlogBundle\Model\Post;
use App\CoreBundle\Database\Repository;

class PostRepository extends Repository
{
    protected $class = Post::class;
    protected $className = Post::_className;
}