<?php


namespace App\BlogBundle\Repository;


use App\BlogBundle\Model\Post;
use App\BlogBundle\Model\User;
use App\CoreBundle\Database\Repository;

class UserRepository extends Repository
{
    protected $class = User::class;
    protected $className = User::_className;
}