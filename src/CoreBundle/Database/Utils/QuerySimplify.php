<?php


namespace App\CoreBundle\Database\Utils;


abstract class QuerySimplify
{
    public static function insert($object)
    {
        $values = [];

        $objectProperties = (new \ReflectionObject($object))->getProperties();

        foreach ($objectProperties as $property) {
            // On met la propriété en public pour pouvoir y accéder
            $property->setAccessible(true);
            if($property->getValue($object) !== null && $property->getName() !== 'class')
            {
                $values[(string)$property->getName()] = (string)$property->getValue($object);
            }
        }
        return $values;

    }
    public static function update($object)
    {
        $values = [];

        $objectProperties = (new \ReflectionObject($object))->getProperties();

        foreach ($objectProperties as $property) {
            // On met la propriété en public pour pouvoir y accéder
            $property->setAccessible(true);
            if($property->getValue($object) !== null && $property->getName() !== 'class')
            {
                $values[$property->getName()] = $property->getValue($object);
            }
        }
        return $values;

    }

    public static function findBy($data)
    {
        $sql = [];


        foreach ($data as $key => $value) {

            $sql[] = "`" . $key . "`='" . $value . "'";

        }
        return implode(' AND ', $sql);

    }
}