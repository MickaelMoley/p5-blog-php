<?php


namespace App\CoreBundle\Form;


class FormBase
{
    private $class;
    private $data;
    private $isSubmitted = false;
    private $newData;

    public function __construct($class, $data)
    {
        $this->class = $class;
        $this->data = $data;
        $this->newData = null;

    }

    public function init(){
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }
    public function getRequestData()
    {
        return $this->newData;
    }

    public function handleRequest($request)
    {
        $data = $request->request->get('form');

//        $methods = get_class_methods($this->data);
//        dump($methods);
//        dump($this->data->{$methods[0]}());


        $objectProperties = (new \ReflectionObject(new $this->class))->getProperties();

        foreach ($objectProperties as $key => $property) {
            // On met la propriété en public pour pouvoir y accéder
            $property->setAccessible(true);
//            dump($property->getName(), $this->data[$key]);
            if($data[$property->getName()] !== null)
            {
//                dump();die;
                //On appelle la fonction de la classe et on défini la nouvelle valeur
                $this->data->{sprintf('set%s', ucfirst($property->getName()))}($data[$property->getName()]);
//                $this->data->set{'title'}($data[$property->getName()]);
            }

        }
        $this->newData = $data;


        if($request->request->get('btn_submit') !== null)
        {
            $this->isSubmitted = true;
        }

    }
    public function createView()
    {
        return $this->data;
    }

    public function isSubmitted(): bool
    {
        if($this->isSubmitted)
        {
            return true;
        }
        else {
            return false;
        }
    }
}