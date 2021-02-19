<?php


namespace App\CoreBundle\Database\Utils;


abstract class QuerySimplify
{
    public static function insert($object)
    {
        $fieldsMap = [];
        $fieldsValueMap = [];

        $objectProperties = (new \ReflectionObject($object))->getProperties();

        foreach ($objectProperties as $property) {
            // On met la propriété en public pour pouvoir y accéder
            $property->setAccessible(true);
            if($property->getValue($object) !== null && $property->getName() !== 'class')
            {
                $fieldsMap[] = (string)$property->getName();
                $fieldsValueMap[] = (string)$property->getValue($object);
            }
        }
        return [
            'fields' => "`" . implode("`,`", $fieldsMap) . "`",
            'values' => "'" . implode("','", $fieldsValueMap) . "'"];

    }
    public static function update($object)
    {
        $sql = [];

        $objectProperties = (new \ReflectionObject($object))->getProperties();

        foreach ($objectProperties as $property) {
            // On met la propriété en public pour pouvoir y accéder
            $property->setAccessible(true);
            if($property->getValue($object) !== null && $property->getName() !== 'class')
            {
                $sql[] = "`" . $property->getName() . "`='" . $property->getValue($object) . "'";
            }
        }
        return $sql;

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