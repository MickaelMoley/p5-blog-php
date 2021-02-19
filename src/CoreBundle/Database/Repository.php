<?php


namespace App\CoreBundle\Database;

use App\CoreBundle\Database\Utils\QuerySimplify;
use Envms\FluentPDO\Exception;
use Envms\FluentPDO\Query;

class Repository
{
    protected $connection;
    protected $class;
    protected $className;
    protected $previousObject;
    private $fluent;

    private $db;

    public function __construct(){

        $this->connection = new Database();
        $this->fluent = new Query($this->connection->getConnection());
        $this->db = $this->connection->getConfig()['database']['db_name'];
    }

    private function getClassName()
    {
        $explode = explode('\\',$this->class);
        return $explode[count($explode) - 1];
    }

    /**
     * Une fonction permettant de sélectionner la table sur laquelle les requêtes SQL vont être effectués
     * @return string
     */
    private function currentContext(): string
    {
        return sprintf('%s.%s',$this->db, $this->className);
    }

    /**
     * Une fonction qui permet de récupérer tous les instances de la classe actuelle dans la table
     * @return array|string
     */
    public function findAll()
    {

        try {
            $query = $this->fluent
                ->from($this->currentContext());
            $objects = [];
            while($object = $query->asObject($this->class)->fetch())
            {
                $objects[] = $object;
            }
            return $objects;
        }
        catch (\PDOException $exception)
        {
            return $exception->getMessage();
        } catch (Exception $e) {
            return $e->getMessage();
        }


    }

    /**
     * Une fonction qui permet de récupérer une instance de classe défini par $id
     * @param $id
     * @return mixed
     */
    public function find(int $id)
    {
        try {
            $query = $this->fluent
                ->from($this->currentContext())
                ->where('id', $id);

            return $query->asObject($this->class)->fetch();
        }
        catch (\PDOException $exception)
        {
            return $exception->getMessage();
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * Une fonction qui permet de récupérer une ou plusieurs instances de classe selon un critère
     * @param array $criteria
     * @return mixed
     */
    public function findBy(array $criteria): array
    {
        try {
            $query = $this->fluent
                ->from($this->currentContext());

            foreach ($criteria as $field => $value)
            {
                $query = $query->where($field, $value);
            }

            $objects = array();
            while($object = $query->asObject($this->class)->fetch())
            {
                $objects[] = $object;
            }
            return $objects;
        }
        catch (\PDOException $exception)
        {
            return $exception->getMessage();
        } catch (Exception $e) {
            return $e->getMessage();
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
        if($object->getId() === null)
        {


            try {
                $fields = QuerySimplify::insert($object);
                return $this->fluent
                    ->insertInto($this->currentContext())
                    ->values($fields)
                    ->execute();
            }
            catch (\PDOException $exception)
            {
                return $exception->getMessage();
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        else {
            //On le met à jour
            try {
                $fields = QuerySimplify::update($object);
                return $this->fluent
                    ->update($this->currentContext())
                    ->set($fields)
                    ->where('id', $object->getId())
                    ->execute();

            }
            catch (\PDOException $exception)
            {
                return $exception->getMessage();
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

    }

    public function delete($object)
    {
        try {
            return $this->fluent
                ->deleteFrom($this->currentContext())
                ->where('id', $object)
                ->execute();
        }
        catch (\Exception $e )
        {
            return $e->getMessage();
        }
    }
}