<?php
namespace App\CoreBundle\Database\Utils;

use \ReflectionObject;
use \InvalidArgumentException;

class ObjectComparator
{

    /**
     * Compare 2 objets
     *
     * @param $o1
     * @param $o2
     * @param $strict Compare
     * @return true si les objects sont égaux, false si les objects sont différents
     */
    public static function equal($o1, $o2, $strict = false)
    {
        return $strict ? $o1 === $o2 : $o1 == $o2;
    }

    /**
     * Trouve la différence entre 2 objets en utilisant la classe Reflector
     *
     * @param $o1
     * @param $o2
     * @return array Les propriétés qui ont changés
     * @throws InvalidArgumentException
     */
    public static function diff($o1, $o2)
    {
        //On vérifie que les paramètres sont bien de type 'object'
        if (!is_object($o1) || !is_object($o2)) {
            throw new InvalidArgumentException("Parameters should be of object type!");
        }

        $diff = [];

        //On compare si les deux objets présents font partis de la même classe
        if (get_class($o1) == get_class($o2)) {
            $o1Properties = (new ReflectionObject($o1))->getProperties();
            $o2Reflected = new ReflectionObject($o2);

            foreach ($o1Properties as $o1Property) {
                $o2Property = $o2Reflected->getProperty($o1Property->getName());
                // Mark private properties as accessible only for reflected class
                $o1Property->setAccessible(true);
                $o2Property->setAccessible(true);
                if (($oldValue = $o1Property->getValue($o1)) != ($newValue = $o2Property->getValue($o2))) {
                    $diff[$o1Property->getName()] = [
                        'old_value' => $oldValue,
                        'new_value' => $newValue
                    ];
                }
            }
        }

        return $diff;
    }
}