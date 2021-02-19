<?php


namespace App\BlogBundle\Repository;


use App\BlogBundle\Model\Comment;
use App\CoreBundle\Database\Repository;

class CommentRepository extends Repository
{
    protected $class = Comment::class;
    protected $className = Comment::_className;
}