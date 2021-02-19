<?php


namespace App\CoreBundle\Database;

use App\CoreBundle\Database\Utils\QuerySimplify;

class Repository
{
    protected $connection;
    protected $class;
    protected $className;
    protected $previousObject;

    public function __construct(){

        $this->connection = new Database();

    }

    private function getClassName()
    {
        $explode = explode('\\',$this->class);
        return $explode[count($explode) - 1];
    }

    /**
     * Sert à récupérer les models de chaque tables
     * @param \stdClass $class
     * @return mixed
     */
    public function findAll()
    {

        try {
            $sql = sprintf('SELECT * FROM `%s`.`%s`', $this->connection->getConfig()['database']['db_name'], strtolower($this->className));
            $query = $this->connection->getConnection()->query($sql);
            $objects = array();
            while ($object = $query->fetchObject($this->class))
            {
                $objects[] = $object;
            }
            return $objects;
        }
        catch (\PDOException $exception)
        {
            return $exception->getMessage();
        }
    }

    /**
     * Sert à récupérer un objet
     * @param $id
     * @return mixed
     */
    public function find(int $id)
    {
        try {
            $object = $this->connection->getConnection()->query(
                sprintf('SELECT * FROM `%s`.`%s` WHERE `id` = %s', $this->connection->getConfig()['database']['db_name'], $this->className, $id)
            )->fetchObject($this->class);
            return  $object;
        }
        catch (\PDOException $exception)
        {
            return $exception->getMessage();
        }

    }

    /**
     * Sert à récupérer un objet
     * @param $id
     * @return mixed
     */
    public function findBy(array $criteria)
    {
        try {
            $fields = QuerySimplify::findBy($criteria);
            $sql = sprintf('SELECT * FROM `%s`.`%s` WHERE %s', $this->connection->getConfig()['database']['db_name'], strtolower($this->className), $fields);
            $query = $this->connection->getConnection()->query($sql);
            $objects = array();
            while ($object = $query->fetchObject($this->class))
            {
                $objects[] = $object;
            }
            return $objects;
        }
        catch (\PDOException $exception)
        {
            return $exception->getMessage();
        }

    }

    /**
     * Sert à enregistrer un element
     * @param $object
     * @return bool|string
     */
    public function persist($object)
    {
      // Si l'obiet n'a pas d'ID alors on crée une nouvelle instance sinon on la modifie
        $fieldsMap = [];
        $fieldsValueMap = [];
        if($object->getId() === null)
        {


            try {
                $fields = QuerySimplify::insert($object);
                $sql = sprintf('INSERT INTO `%s`.`%s` (%s) VALUES (%s)',
                    $this->connection->getConfig()['database']['db_name'],
                    strtolower($this->className),
                    $fields['fields'],
                    $fields['values']
                );
                $request = $this->connection->getConnection()->query($sql);
                if ($request)
                {
                    return $this->connection->getConnection()->lastInsertId();
                }
                else {
                    return 'Une erreur est survenue';
                }
            }
            catch (\PDOException $exception)
            {
                return $exception->getMessage();
            }
        }
        else {
            //On le met à jour
            try {
                $sql = sprintf('UPDATE `%s`.`%s` SET %s WHERE `id`= %s',
                    $this->connection->getConfig()['database']['db_name'],
                    strtolower($this->className),
                    implode(',',QuerySimplify::update($object)),
                    $object->getId()
                );

                if ($this->connection->getConnection()->query($sql))
                {
                    return true;
                }
                else {
                    return 'Une erreur est survenue';
                }
            }
            catch (\PDOException $exception)
            {
                return $exception->getMessage();
            }
        }

    }

    /**
     * Sert à supprimer un element
     * @param $object
     */
    public function delete($object)
    {
        $sql = sprintf('DELETE FROM `%s`.`%s` WHERE %s',
            $this->connection->getConfig()['database']['db_name'],
            strtolower($this->className),
            (int)$object->getId()
        );
//        dump($this->connection->getConnection()->query($sql));
        try {

            return $this->connection->getConnection()->query($sql);
        }
        catch (\PDOException $exception)
        {
            return $exception->getMessage();
        }

    }
}